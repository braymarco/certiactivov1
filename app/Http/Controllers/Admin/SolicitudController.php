<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Enums\DocumentTypes;
use App\Enums\FormatoFirma;
use App\Enums\SignatureRequestStatus;
use App\Enums\TipoDocumentoID;
use App\Enums\UtilsEnum;
use App\Enums\VariableEtiquetas;
use App\Exceptions\ExistProviderRequestException;
use App\Exceptions\NotFoundException;
use App\Exceptions\SyncException;
use App\Facades\ConfigFacade;
use App\Facades\FileFacade;
use App\Facades\HistoryFacade;
use App\Facades\Notify;
use App\Facades\SignatureRequestFacade;
use App\Facades\UanatacaFacade;
use App\Helpers\Uanataca\Exceptions\ClientException;
use App\Helpers\Uanataca\Exceptions\ForbiddenException;
use App\Helpers\Uanataca\Exceptions\MethodNotAllowedException;
use App\Helpers\Uanataca\Exceptions\ServerException;
use App\Helpers\Uanataca\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Models\Canton;
use App\Models\Document;
use App\Models\DocumentUpdate;
use App\Models\History;
use App\Models\Plan;
use App\Models\Provincia;
use App\Models\SignatureRequest;
use Carbon\Carbon;

class SolicitudController extends Controller
{
    public function solicitud($id)
    {
        $solicitud = SignatureRequest::find($id);
        if ($solicitud === null)
            return "Esta solicitud no existe";
        $solicitud->with('additionalInfo');
        //valida si ya se aprobaron los requisitos
        if (!in_array($solicitud->estado, [
            SignatureRequestStatus::$CREATED,
            SignatureRequestStatus::$CREATED,
            SignatureRequestStatus::$DOCUMENT_CHANGE,
            SignatureRequestStatus::$DELETED,
        ]))
            return $this->formularioOk($id);
        $requisitosPorTipo = $solicitud->requisitosActivos();
        $cantonesM = Canton::all();
        $cantones = [];
        foreach ($cantonesM as $cantonM) {
            if (!isset($cantones[$cantonM->provincia_id]))
                $cantones[$cantonM->provincia_id] = [];
            $cantones[$cantonM->provincia_id][] = $cantonM;
        }
        $documentosLabel = DocumentTypes::str();
        $plan = $solicitud->plan;
        $planes = Plan::all();
        return view('dashboard.solicitud', [
            'solicitud' => $solicitud,
            'estadosSolicitud' => SignatureRequestStatus::$STR,
            'requisitosPorTipo' => $requisitosPorTipo,
            'tiposRequisito' => DocumentTypes::class,
            'countries' => UtilsEnum::$countries,
            'provincias' => Provincia::all(),
            'cantones' => $cantones,
            'documentosLabel' => $documentosLabel,
            'planes' => $planes
        ]);

    }

    public function descargarRequisito($documentoId)
    {
        $documento = Document::find($documentoId);
        if ($documento === null)
            return "Esta solicitud no existe";
        return FileFacade::requisito($documento->path);
    }

    public function actualizarDatos()
    {
        $this->request->validate([
            'solicitud' => 'required'
        ]);
        $solicitud = SignatureRequest::find($this->request->solicitud);
        if ($solicitud == null)
            return back()->withErrors(['error' => "La solicitud no exite"]);
        if (!in_array($solicitud->estado, [
            SignatureRequestStatus::$CREATED,
            SignatureRequestStatus::$DOCUMENT_CHANGE,
        ]))
            return back()->withErrors(['error' => "La solicitud no puede ser actualizada, estado: " . $solicitud->estadoStr()]);
        $form = $this->request->validate([
            'tipo_documento' => 'nullable',
            'nro_documento' => 'nullable',
            'codigo_dactilar' => 'nullable',
            'nombres' => 'nullable',
            'apellido1' => 'nullable',
            'apellido2' => 'nullable',
            'fecha_nacimiento' => 'nullable',
            'nacionalidad' => 'nullable',
            'sexo' => 'nullable',
            'celular' => 'nullable',
            'email' => 'nullable',

            'con_ruc' => 'nullable',
            'nro_ruc' => 'nullable',
            'empresa' => 'nullable',
            'cargo' => 'nullable',
            'unidad' => 'nullable',
            'tipo_documento_rl' => 'nullable',
            'nro_documento_rl' => 'nullable',
            'nombres_rl' => 'nullable',
            'apellido1_rl' => 'nullable',
            'apellido2_rl' => 'nullable',
            'provincia_id' => 'nullable',
            'canton_id' => 'nullable',
            'direccion' => 'nullable',
            'formato' => 'nullable',
            'plan_id' => 'nullable',
            'sn_token' => 'nullable',
        ]);
        if ($this->request->has('con_ruc'))
            $form['con_ruc'] = 1;
        else
            $form['con_ruc'] = 0;
        $totalCambios = 0;
        foreach ($form as $key => $value) {
            if ($value != $solicitud->$key) {
                $etiquetaVariable = VariableEtiquetas::$etiquetas[$key] ?? $key;
                $description = "Actualización: " . $etiquetaVariable .
                    ' -> ' . $solicitud->$key . ' -> ' . $value;
                HistoryFacade::create(
                    $description,
                    $solicitud->id
                );
                $solicitud->update([
                    $key => $value
                ]);
                $totalCambios++;
            }

        }
        return back()->with(['message' => "Cambios realizados: $totalCambios"]);

    }

    public function actualizarEstadoSolicitud()
    {

    }

    public function aprobarRequisitos()
    {
        $this->request->validate([
            'solicitud' => 'required'
        ]);
        $solicitud = SignatureRequest::find($this->request->solicitud);
        if ($solicitud == null)
            return redirect()->back()->withErrors([
                'error' => 'La solicitud no existe'
            ]);
        if (!in_array($solicitud->estado, [
            SignatureRequestStatus::$CREATED,
            SignatureRequestStatus::$DOCUMENT_CHANGE,
        ]))
            return redirect()->back()->withErrors([
                'error' => 'La solicitud no existe - estado ' . SignatureRequestStatus::$STR_LOCAL[$solicitud->estado]
            ]);
        //validamos que los documentos no estén en estado pendiente
        $requisitos = $solicitud->requisitosActivos();
        foreach ($requisitos as $requisito) {
            if ($requisito->status != DocumentStatus::$CREATED
                && $requisito->status != DocumentStatus::$APPROVED)
                return back()->withErrors([
                    'error' => 'El requisito no es válido para su aprobación: ' . $requisito->type
                ]);
        }

        $solicitud->update([
            'estado' => SignatureRequestStatus::$APPROVED_REQUIREMENTS
        ]);
        HistoryFacade::create('Requisitos en validación',
            $solicitud->id,
        );
        $incomeNotifyGroup = ConfigFacade::get("FIRMA_NOTIFY_GROUP", false);
        if ($incomeNotifyGroup)
            Notify::whatapi('certiactivo',
                '593995088516',
                "🖋️ Firma electrónica - enviar documentos");
        try {
            UanatacaFacade::sendRequest($solicitud->id);
        } catch (ExistProviderRequestException $e) {
            try {
                UanatacaFacade::checkStatus($solicitud->id);
            } catch (NotFoundException|ClientException|ForbiddenException|MethodNotAllowedException|ServerException|UnauthorizedException $e) {
                return back()->withErrors(['error' => "Error al generar la firma electrónica."]);
            }
        } catch (NotFoundException|ClientException|SyncException|MethodNotAllowedException|ForbiddenException|ServerException|UnauthorizedException $e) {
            return back()->withErrors(['error' => "Error al generar la firma electrónica."]);
        }
        $solicitud->update([
            'fecha_requisitos_validados' => Carbon::now()
        ]);
        return back()->with(['message' => "Requisitos aprobados"]);

    }

    public function formularioOk($id)
    {
        $solicitud = SignatureRequest::find($id);
        if ($solicitud === null)
            return "Esta solicitud no existe";
        $solicitud->with('additionalInfo');
        $estadosSolicitud = SignatureRequestStatus::class;
        $requisitosPorTipo = $solicitud->requisitosActivos();
        $uRequest = $solicitud->uanatacaRequestFirst();
        if ($uRequest !== null) {
            $messageResponse = "Estado: " . $uRequest->estado . " \n" . str_replace("<br>", "\n", $uRequest->observacion);

        } else {
            $messageResponse = "No tiene una solciitud de proveedor activa, sincronice";
        }

        $internalResponse = explode("|", $solicitud->provider_response)[0];
        return view('dashboard.solicitud_ok', [
            'solicitud' => $solicitud,
            'tiposDocumentoID' => TipoDocumentoID::$STR,
            'formatosFirma' => FormatoFirma::$STR,
            'requisitosPorTipo' => $requisitosPorTipo,
            'documentosLabel' => DocumentTypes::str(),
            'estadosSolicitud' => $estadosSolicitud,
            'messageResponse' => $messageResponse,
            'internalResponse' => $internalResponse,
        ]);
    }

    public function proveedorCambioDocumentacion($id)
    {

        $solicitud = SignatureRequest::find($id);
        if ($solicitud == null)
            return redirect()->back()->withErrors([
                'error' => 'La solicitud no existe'
            ]);
        if (!in_array($solicitud->estado, [
            SignatureRequestStatus::$APPROVED_REQUIREMENTS,
            SignatureRequestStatus::$ERROR_SENDING_SUPPLIER,
            SignatureRequestStatus::$ASSIGNED_SUPPLIER,
        ]))
            return redirect()->back()->withErrors([
                'error' => 'La solicitud no tiene documentos aprobados '
            ]);
        $solicitud->update([
            'estado' => SignatureRequestStatus::$CREATED
        ]);
        $requisitos = $solicitud->requisitosActivos();
        foreach ($requisitos as $requisito) {
            $requisito->update([
                'status' => DocumentStatus::$CREATED
            ]);
        }
        HistoryFacade::create('Notificación cambio de documentos desde el proveedor',
            $solicitud->id,
            2
        );
        return back()->with(['message' => "Seleccione Documento a cambiar"]);
    }

    public function enviarProveedor($id)
    {

        $solicitud = SignatureRequest::find($id);
        if ($solicitud == null)
            return redirect()->back()->withErrors([
                'error' => 'La solicitud no existe'
            ]);

        try {
            UanatacaFacade::sendRequest($solicitud->id);
        } catch (ExistProviderRequestException $e) {
            try {
                UanatacaFacade::checkStatus($solicitud->id);
            } catch (NotFoundException|ClientException|ForbiddenException|MethodNotAllowedException|ServerException|UnauthorizedException $e) {
                return back()->withErrors(['error' => "Error al generar la firma electrónica status."]);
            }
        } catch (NotFoundException|ClientException|SyncException|MethodNotAllowedException|ForbiddenException|ServerException|UnauthorizedException $e) {
            return back()->withErrors(['error' => "Error al generar la firma electrónica. " . $e->getMessage()]);
        }
        return back()->with(['message' => "Firma enviada al proveedor"]);
    }

    public function checkStatus($id)
    {
        $solicitud = SignatureRequest::find($id);
        if ($solicitud == null)
            return redirect()->back()->withErrors([
                'error' => 'La solicitud no existe'
            ]);
        UanatacaFacade::checkStatus($solicitud->id);
        return back()->with(['message' => "Verificando estado..."]);
    }

    public function firmaEmitida($id)
    {

        $solicitud = SignatureRequest::find($id);
        if ($solicitud == null)
            return redirect()->back()->withErrors([
                'error' => 'La solicitud no existe'
            ]);
        if (!in_array($solicitud->estado, [
            SignatureRequestStatus::$APPROVED_REQUIREMENTS,
            SignatureRequestStatus::$ASSIGNED_SUPPLIER,
            SignatureRequestStatus::$SENDING_PROVIDER,
            SignatureRequestStatus::$ERROR_SENDING_SUPPLIER,
            SignatureRequestStatus::$SENT_SUPPLIER,
        ]))
            return redirect()->back()->withErrors([
                'error' => 'La solicitud se encuentra en estado: '
                    . SignatureRequestStatus::$STR_LOCAL[$solicitud->estado]
            ]);
        SignatureRequestFacade::solicitudAprobada($solicitud);
        return back()->with(['message' => "Firma Generada"]);
    }

    public function pedirCambioRequisito()
    {
        $this->request->validate([
            'documento_id' => 'required',
            'comentario' => 'required'
        ]);
        $comentario = $this->request->comentario;
        $documento = Document::find($this->request->documento_id);
        if ($documento == null)
            return back()->withErrors(['error' => "Documento no existe"]);


        if (!in_array($documento->status, [
            DocumentStatus::$CREATED,
        ]))
            return back()->withErrors([
                'error' => "No se puede enviar a revisión, el estado del documento es: " . $documento->statusStr()
            ]);
        \DB::transaction(function () use ($documento, $comentario) {
            $documento->update([
                'status' => DocumentStatus::$NEED_UPDATE
            ]);
            $documento->signatureRequest->update([
                'estado' => SignatureRequestStatus::$DOCUMENT_CHANGE
            ]);
            $docUp = DocumentUpdate::create([
                'previus_document_id' => $documento->id,
                'comentario' => $comentario,
                'token' => \Str::random(40),
                'type' => $documento->type
            ]);
            HistoryFacade::create('Se necesita realizar un cambio: ' .
                $documento->type . ' - ' . $comentario,
                $documento->signatureRequest->id,

            );
            SignatureRequestFacade::notificarCambioDocumento(
                $documento->signatureRequest,
                $docUp
            );
        });

        return back()->with([
            'message' => 'El documento ha sido enviado a revisión'
        ]);
    }

    public function cambiarArchivoRequisito()
    {
        $this->request->validate([
            'documento_id' => 'required',
            'archivo' => 'required|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240'
        ]);

        $documento = Document::find($this->request->documento_id);
        if ($documento == null)
            return back()->withErrors(['error' => "Documento no existe"]);

        $solicitud = $documento->signatureRequest;
        if ($solicitud == null)
            return back()->withErrors(['error' => "Solicitud no existe"]);

        if (!in_array($solicitud->estado, [
            SignatureRequestStatus::$CREATED,
        ]))
            return back()->withErrors([
                'error' => "La solicitud no está en estado de revisión"
            ]);

        $documentType = $documento->type;
        $mimes = DocumentTypes::mimes();
        $mimes = $mimes[$documentType];

        $this->request->validate([
            'archivo' => 'required|mimes:' . $mimes . '|max:10240'
        ]);

        try {
            $storage = \Storage::disk('requisitos');

            // Actualizamos el estado del documento anterior
            $documento->update([
                'status' => DocumentStatus::$UPDATED
            ]);

            $file = $this->request->file('archivo');
            // Agregamos timestamp para mantener histórico de documentos
            $fileName = $documentType . "_" . time() . "." . $file->getClientOriginalExtension();
            $path = $solicitud->id . "/" . $fileName;

            $uploaded = $storage->put(
                $path,
                file_get_contents($file->getRealPath())
            );

            if (!$uploaded)
                throw new \Exception("Error al subir el archivo");

            // Creamos el nuevo documento
            $newDocument = Document::create([
                'name' => $fileName,
                'path' => $path,
                'type' => $documentType,
                'status' => DocumentStatus::$CREATED,
                'signature_request_id' => $solicitud->id
            ]);

            HistoryFacade::create(
                'Archivo actualizado desde admin: ' . DocumentTypes::str()[$documentType],
                $solicitud->id
            );

            return back()->with(['message' => 'Archivo actualizado correctamente']);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar el archivo: ' . $e->getMessage()]);
        }
    }


}
