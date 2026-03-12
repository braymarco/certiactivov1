<?php

namespace App\Http\Controllers;

use App\Enums\DocumentStatus;
use App\Enums\DocumentTypes;
use App\Enums\DocumentUpdateStatus;
use App\Enums\FormatoFirma;
use App\Enums\PurchaseTokenStatus;
use App\Enums\SignatureRequestStatus;
use App\Enums\SignatureRequestTypes;
use App\Enums\UtilsEnum;
use App\Exceptions\SignatureRequestRateException;
use App\ExternalServices\Identidata\Exceptions\NetworkException;
use App\ExternalServices\Identidata\Exceptions\NotFoundException;
use App\ExternalServices\Identidata\Identidata;
use App\Facades\ConfigFacade;
use App\Facades\DocFacade;
use App\Facades\FileFacade;
use App\Facades\HistoryFacade;
use App\Facades\Notify;
use App\Facades\SignatureRequestFacade;
use App\Helpers\ValidarIdentificacion;
use App\Models\Canton;
use App\Models\Cliente;
use App\Models\Document;
use App\Models\DocumentUpdate;
use App\Models\History;
use App\Models\Plan;
use App\Models\Provincia;
use App\Models\PurchaseToken;
use App\Models\SignatureRequest;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Throwable;

class SignatureRequestController extends Controller
{
    public function selectType($purchaseToken)
    {
        $purchaseTokenFound = PurchaseToken::where('token', $purchaseToken)->first();
        if ($purchaseTokenFound->status !== PurchaseTokenStatus::$CREATED)
            return "Link Utilizado";
        if ($purchaseTokenFound == null)
            return "Link Inválido";

        return view('signature_request.seleccionar_tipo', [
            'title' => 'Firma Electrónica',
            'linkPnatural' => route('signature-request.requirements', [
                'type' => SignatureRequestTypes::$P_NATURAL,
                'purchaseToken' => $purchaseTokenFound->token,
            ]),
            'linkRempresa' => route('signature-request.requirements', [
                'type' => SignatureRequestTypes::$REPRESENTANTE_EMPRESA,
                'purchaseToken' => $purchaseTokenFound->token,
            ]),
            'linkMempresa' => route('signature-request.requirements', [
                'type' => SignatureRequestTypes::$M_EMPRESA,
                'purchaseToken' => $purchaseTokenFound->token,
            ]),
            'purchaseTokenFound' => $purchaseTokenFound
        ]);
    }
    public function getName()
    {
        $this->request->validate([
            'identification' => 'required'
        ]);
        $identidata = new Identidata(config('services.identidata.key'));
        try {
            $response = $identidata->queryCedula($this->request->identification);
            return response()->json([
                'status' => 'success',
                'data' => [
                    'fullName' => $response->fullName,
                    'identification' => $response->identificacion,
                    'name' => $response->name,
                    'firstSurname' => $response->firstSurname,
                    'secondSurname' => $response->secondSurname,
                    'email' => $response->email,
                    'address' => $response->address,
                ]
            ]);
        } catch (NetworkException|GuzzleException $e) {
            return response()->json([
                'status' => 'error'
            ]);
        } catch (NotFoundException $e) {
            return response()->json([
                'status' => 'not_found'
            ]);
        }

    }

    public function requisitos($type, $purchaseToken)
    {
        if (!in_array($type, [
            SignatureRequestTypes::$P_NATURAL,
            SignatureRequestTypes::$REPRESENTANTE_EMPRESA,
            SignatureRequestTypes::$M_EMPRESA,
        ]))
            return "Link incorrecto";
        $purchaseTokenFound = PurchaseToken::where('token', $purchaseToken)->first();
        if ($purchaseTokenFound->status !== PurchaseTokenStatus::$CREATED)
            return "Link Utilizado";
        if ($purchaseTokenFound == null)
            return "Link Inválido";
        $provincias = Provincia::all();
        $cantonesM = Canton::all();
        $cantones = [];
        foreach ($cantonesM as $cantonM) {
            if (!isset($cantones[$cantonM->provincia_id]))
                $cantones[$cantonM->provincia_id] = [];
            $cantones[$cantonM->provincia_id][] = $cantonM;
        }
        $plan = $purchaseTokenFound->plan;
        $planes = [$plan];
        $documentos = DocumentTypes::porTipoSolicitud();
        $documentosNecesarios = $documentos[$type];
        $documentosLabel = DocumentTypes::str();
        return view('signature_request.requisitios', [
            'purchaseToken' => $purchaseTokenFound,
            'countries' => UtilsEnum::$countries,
            'provincias' => $provincias,
            'cantones' => $cantones,
            'planes' => $planes,
            'tipo' => $type,
            'documentosNecesarios' => $documentosNecesarios,
            'documentTypes' => DocumentTypes::class,
            'documentosLabel' => $documentosLabel,
        ]);
    }

    public function generar($type, $purchaseToken)
    {
        $this->request->flash();
        if (!in_array($type, [
            SignatureRequestTypes::$P_NATURAL,
            SignatureRequestTypes::$REPRESENTANTE_EMPRESA,
            SignatureRequestTypes::$M_EMPRESA,
        ]))
            return "Link incorrecto";
        $purchaseTokenFound = PurchaseToken::where('token', $purchaseToken)->first();
        if ($purchaseTokenFound->status !== PurchaseTokenStatus::$CREATED)
            return "Link Utilizado";
        if ($purchaseTokenFound == null)
            return "Link Inválido";


        $variables = DocumentTypes::variablesPorTipoSolicitud();
        // $variables = $variables[$type];
        //valida las variables necesarias
        //$varAdicionales = $this->request->validate($variables);

        $varAdicionales = $variables[$type];

        $formComun = $this->request->validate([
            'tipo_documento' => 'required|in:1,2',
            'nro_documento' => 'required|max:13|min:10',
            'codigo_dactilar' => 'required|size:10',
            'nombres' => 'required|min:3|max:150',
            'apellido1' => 'required|min:3|max:150',
            'apellido2' => 'nullable|min:3',
            'fecha_nacimiento' => 'required|date',
            'nacionalidad' => 'required',
            'sexo' => 'required',
            'celular' => 'required',
            'email' => 'required|email',
            'con_ruc' => 'required',
            //'nro_ruc' => 'nullable',
            'provincia_id' => 'required',
            'canton_id' => 'required',
            'direccion' => 'required|min:4|max:150',
            'formato' => 'required|in:1,2',
            'plan_id' => 'required',
            'token' => 'string'
            //'sn_token' => 'required',
        ]);

        $numeroDocumento = $formComun['nro_documento'];
        try {
            \DB::transaction(function () use ($numeroDocumento) {
                $cliente = Cliente::lockForUpdate()->where('identification', $numeroDocumento);
                $date5Minutes = Carbon::now();
                $date5Minutes->subMinutes(5);
                $total = SignatureRequest::select('nro_documento')
                    ->where('nro_documento', $numeroDocumento)
                    ->where('created_at', '>=', $date5Minutes)
                    //->where('estado', '!=', SignatureRequestStatus::$ISSUED)
                    ->where('estado', '!=', SignatureRequestStatus::$DELETED)
                    ->get()->count();

                if ($total > 0) {
                    throw new SignatureRequestRateException("Debe esperar 5 minutos antes de enviar una nueva petición para un mismo número de documento.");
                }


            });
        } catch (SignatureRequestRateException|Throwable $e) {
            return back()->withErrors([
                'error' => 'Debe esperar al menos 5 minutos antes de enviar una solicitud con el mismo número de documento, ' . $e->getMessage()
            ]);

        }


        //firmas con los mismos datos
        $totalSignatures = 0;
        $date1Month = Carbon::now();
        $date1Month->subMonth();
        $total = SignatureRequest::select('nro_documento')
            ->where('celular', $formComun['celular'])
            ->groupBy('nro_documento')
            //->where('created_at', '>=', $date1Month)
            ->where('estado', '!=', SignatureRequestStatus::$DELETED)
            ->get()->count();
        if ($total >= 4) {
            return back()->withErrors(['error' => 'Ha utilizado el mismo celular en distintas solicitudes']);
        }
        $total = SignatureRequest::select('nro_documento')
            ->where('email', $formComun['email'])
            //->where('created_at', '>=', $date1Month)
            ->groupBy('nro_documento')
            ->where('estado', '!=', SignatureRequestStatus::$DELETED)
            ->get()->count();
        if ($total >= 4) {
            return back()->withErrors(['error' => 'Ha utilizado el mismo correo en distintas solicitudes']);
        }
        $plan = Plan::find($formComun['plan_id']);
        if ($plan === null || $purchaseTokenFound->plan_id !== $plan->id)
            return back()->withErrors(['error' => "Plan inválido"]);
        if ($this->request->con_ruc == '1' or $type != SignatureRequestTypes::$P_NATURAL)
            $varAdicionales['nro_ruc'] = 'required|size:13';
        if ($this->request->con_ruc == '1' or $type != SignatureRequestTypes::$P_NATURAL)
            $formComun['con_ruc'] = 1;
        else
            $formComun['con_ruc'] = 0;
        if ($formComun['formato'] == FormatoFirma::$TOKEN)
            $varAdicionales ['sn_token'] = 'required';
        //valida form adicional
        $formAdicional = $this->request->validate($varAdicionales);

        if ($formComun['con_ruc']==1 && $plan->duration_unit=='day' && $plan->duration<30){
            return back()->withErrors(['error' => 'La firma electrónica con RUC solo se puede emitir por al menos 30 días.']);
        }
        $form = array_merge($formComun, $formAdicional);
        //en mayúsucla
        $form = array_map('strtoupper', $form);
        $form = array_map('trim', $form);

        //valida cédula
        $validador = new ValidarIdentificacion();

        if (strlen($form['nro_documento']) == 10) {
            try {
                if (!$validador->validarCedula($form['nro_documento'])
                    && !$validador->validarRucPersonaNatural($form['nro_documento'])) {
                    return back()->withErrors(['error' => "Identificación Inválida"]);
                }
            } catch (\Exception $e) {
                return back()->withErrors(['error' => "Identificación Inválida"]);
            }
        }
        //valida nacionalidad
        if (!in_array($form['nacionalidad'], UtilsEnum::$countries))
            return back()->withErrors(['error' => "Nacionalidad inválida"]);
        $provincia = Provincia::find($form['provincia_id']);
        if ($provincia === null)
            return back()->withErrors(['error' => "Provincia inválida"]);
        $canton = Canton::find($form['canton_id']);
        if ($canton === null)
            return back()->withErrors(['error' => "Cantón inválido"]);
        if ($canton->provincia->id !== $provincia->id)
            return back()->withErrors(['error' => "El cantón no pertenece a esta provincia"]);
        //actualiza a texto la provincia y cantón
        /* $form['provincia'] = $provincia->nombre;
         $form['canton'] = $canton->nombre;*/
        //valida sexo
        if (!in_array($form['sexo'], ['HOMBRE', 'MUJER']))
            return back()->withErrors(['error' => "Sexo inválido"]);

        //valida celular
        $celular = $form['celular'];
        if (!str_starts_with($celular, '09') || strlen($celular) !== 10)
            return back()->withErrors(['error' => "Celular inválido"]);


        //VALIDA DOCUMENTOS
        $documentos = DocumentTypes::porTipoSolicitudRequired();
        $documentosNecesarios = $documentos[$type];
        //construimos validador
        $mimeTypes = DocumentTypes::mimes();
        $mimes = array_intersect_key($mimeTypes, array_flip($documentosNecesarios));
        foreach ($mimes as $key => &$value)
            $value = 'required|mimes:' . $value . '|between:1,' . (1024 * 50);
        $verify = array_combine($documentosNecesarios, $mimes);

        $formDocumentosComun = $this->request->validate($verify);
        $docAdicionales = [];
        if ($type === 'mempresa') {
            $docAdicionales['COPIA_RUC'] = 'required|mimes:pdf|between:1,' . (1024 * 50);
        } /*else {
            if ($this->request->con_ruc == '1')
                $docAdicionales['RUC'] = 'required|mimes:pdf|between:1,' . (1024 * 50);
        }*/

        //valida video
        $fechaNacimiento = Carbon::createFromFormat('Y-m-d', $form['fecha_nacimiento']);
        $edad = Carbon::now()->diffInYears($fechaNacimiento);
        if ($edad > 64)
            $docAdicionales['VIDEO'] = 'required|mimes:mp4|between:1,' . (1024 * 100);


        $formDocumentosAdicionales = $this->request->validate($docAdicionales);

        $formDocumentos = array_merge($formDocumentosComun, $formDocumentosAdicionales);

        $form['tipo'] = $type;
        $signatureRequest = DB::transaction(function () use ($form, $formDocumentos, $purchaseTokenFound) {
            $form['token'] = \Str::random(40);
            $form['ip'] = $this->request->ip();
            $signatureRequest = SignatureRequest::create($form);
            $purchaseTokenFound->update([
                'status' => PurchaseTokenStatus::$USED,
                'signature_request_id' => $signatureRequest->id,
            ]);
            HistoryFacade::create(
                'Proceso Iniciado',
                $signatureRequest->id
            );
            $storage = Storage::drive('requisitos');
            $storage->makeDirectory($signatureRequest->id);
            foreach ($formDocumentos as $key => $formDocumento) {
                $file = $this->request->file($key);

                $fileName = $key . "." . $file->getClientOriginalExtension();
                $path = $signatureRequest->id . "/" . $fileName;
                $uploaded = $storage->put(
                    $path,
                    file_get_contents($file->getRealPath())
                );
                if (!$uploaded)
                    throw new \Exception("Error al mover un archivo");
                $document = Document::create([
                    'name' => $fileName,
                    'path' => $path,
                    'type' => $key,
                    'status' => DocumentStatus::$CREATED,
                    'signature_request_id' => $signatureRequest->id
                ]);


            }
            return $signatureRequest;
        });
        //envia el enlace por los medio de comunicación
        $this->request->flush();
        SignatureRequestFacade::notificarSolicitudCliente($signatureRequest);
        return view('success', [
            'proceso' => $signatureRequest
        ]);
    }

    public function actualizarDocumentoVista($token)
    {
        $docUp = DocumentUpdate::where('token', $token)->first();
        if ($docUp == null)
            return "Link inválido";
        if ($docUp->status != DocumentUpdateStatus::$CREATED)
            return "El link ya ha sido utilizado";

        $str = DocumentTypes::str();
        return view('update_document', [
            'docUp' => $docUp,
            'label' => $str[$docUp->previusDocument->type],
        ]);
    }

    public function downloadPreviusDocument($token)
    {
        $docUp = DocumentUpdate::where('token', $token)->first();
        if ($docUp == null || $docUp->status != DocumentUpdateStatus::$CREATED)
            return "Link inválido";
        return FileFacade::requisito($docUp->previusDocument->path);

    }

    public function actualizarDocumento($token)
    {
        $docUp = DocumentUpdate::where('token', $token)->first();
        if ($docUp == null)
            return "Link inválido";
        if ($docUp->status != DocumentUpdateStatus::$CREATED)
            return "El link ya ha sido utilizado";
        //validamos que el documento esté pendiente de actualización
        if ($docUp->previusDocument->status != DocumentStatus::$NEED_UPDATE)
            return "El documento no necesita actualización, o el enlace expiró";
        $documentType = $docUp->previusDocument->type;
        $mimes = DocumentTypes::mimes();
        $mimes = $mimes[$documentType];
        $this->request->validate([
            $documentType => 'required|mimes:' . $mimes
        ]);

        $storage = Storage::disk('requisitos');
        $signatureRequest = $docUp->previusDocument->signatureRequest;
        //actualizamos los estados del link de cambio y del documento enviado anteriormente
        $docUp->update([
            'status' => DocumentUpdateStatus::$USED
        ]);
        $docUp->previusDocument->update([
            'status' => DocumentStatus::$UPDATED
        ]);
        $file = $this->request->file($documentType);
        //agregamos la fecha unix del documento para mantener documentos anteriores
        $fileName = $docUp->type . "_" . time() . "." . $file->getClientOriginalExtension();
        $path = DocFacade::route($signatureRequest->id, $fileName);
        $uploaded = $storage->put(
            $path,
            file_get_contents($file->getRealPath())
        );
        $document = Document::create([
            'name' => $fileName,
            'path' => $path,
            'type' => $documentType,
            'status' => DocumentStatus::$CREATED,
            'signature_request_id' => $signatureRequest->id
        ]);
        //actualizamos el link con el nuevo documento agregado
        $docUp->update([
            'document_id' => $document->id
        ]);

        //actualizamos el estado de la solicitud
        $tieneRPendientes = false;
        $requisitos = $document->signatureRequest->requisitosActivos();
        foreach ($requisitos as $requisito) {
            if ($requisito->status == DocumentStatus::$NEED_UPDATE) {
                $tieneRPendientes = true;
                break;
            }
        }

        if (!$tieneRPendientes) {
            $document->signatureRequest->update([
                'estado' => SignatureRequestStatus::$CREATED
            ]);
            $incomeNotifyGroup = ConfigFacade::get("FIRMA_NOTIFY_GROUP", false);
            if ($incomeNotifyGroup)
                Notify::whatapiNameGroup('certiactivo',
                    'SUPPORT_GROUP',
                    "🖋️ Documentos de firma actualizados - revisar nuevamente documentación");
        }

        HistoryFacade::create(
            'Documento actualizado ' . $documentType,
            $signatureRequest->id,
        );
        return view('success_update');

    }
}
