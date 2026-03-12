<?php

namespace App\Facades;

use App\Enums\DocumentStatus;
use App\Enums\SignatureRequestStatus;
use App\Helpers\Uanataca\Enum\EstadoSolicitud;
use App\Mail\CambioDocumentoMail;
use App\Mail\InicioSolicitudMail;
use App\Models\DocumentUpdate;
use App\Models\SignatureRequest;
use App\Models\UanatacaRequest;
use Mail;

class SignatureRequestFacade
{
    public static function notificarSolicitudCliente(SignatureRequest $solicitud): void
    {
        $mensaje = "Hola *" . $solicitud->shortName() . "*\n\n"
            . "Tu solicitud de firma electrónica acaba de ser ingresada, pasará a un estado de revisión de datos y documentación, al finalizar esta etapa se enviará un enlace a su correo registrado.\n\n"
            . "Para conocer más detalles sobre el estado de su proceso, puede ingresar al siguiente link (recuerde no compartirlo con nadie): " . $solicitud->linkCliente();
        Notify::whatapi('certiactivo', $solicitud->celularGlobal(), $mensaje);
        Mail::to($solicitud->email)
            ->queue(new InicioSolicitudMail($solicitud));

        $incomeNotifyGroup = ConfigFacade::get("FIRMA_NOTIFY_GROUP", false);
        if ($incomeNotifyGroup)
            Notify::whatapiNameGroup('certiactivo',
                'SUPPORT_GROUP',
                "🖋️ Nueva Firma Electrónica - validar documentos");
    }

    public static function notificarCambioDocumento(SignatureRequest $solicitud, DocumentUpdate $docUp)
    {
        $mensaje = "*Firma Electrónica Certiactivo - Observación*\n\n"
            . "Hola {$solicitud->shortName()}\n\n
La solicitud de {$solicitud->fullName()} dentificación {$solicitud->nro_documento}, requiere el cambio de uno de los documentos de su solicitud detallado a continuación. Una vez modificado se realizará la verificación y posterior aprobación de su certificado de firma electrónica.\n
Para actualizar su documento ingrese al siguiente link: " . $docUp->linkUpdate();

        Notify::whatapi('certiactivo', $solicitud->celularGlobal(), $mensaje);
        Mail::to($solicitud->email)
            ->queue(new CambioDocumentoMail($solicitud, $docUp));
    }

    public static function solicitudAprobada($solicitud)
    {
        $solicitud->update([
            'estado' => SignatureRequestStatus::$ISSUED
        ]);
        $requisitos = $solicitud->requisitosActivos();
        foreach ($requisitos as $requisito) {
            $requisito->update([
                'status' => DocumentStatus::$APPROVED
            ]);
        }
        HistoryFacade::create('Firma Generada',
            $solicitud->id,

        );
        $mensaje = "Su firma acaba de ser aprobada

Pasos para descargar la firma:
* Nota: debe realizar estos pasos de preferencia desde un computador
* Debe tener acceso a los sms del número de celular enviado al inicio
1.- Acceder al link que le llegó al correo.
2.- Leer y aceptar el contrato.
3.- Esperar un mensaje de texto e ingresarlo en el portal.
4.- Ingresar una clave para su firma electrónica (de preferencia letras y números, sin “ñ” o caracteres especiales, esta clave no debe olvidarla ya que no es posible recuperarla).
5.- Click en continuar y esperar que sea generada su firma (no salir de esta página).
6.- Le mostrará un botón de descargar firma. Click allí.
El archivo descargado es su firma electrónica (adicional le llegará una copia a su correo), no la pierda ya que no es posible volver a descargarla y se tendría que emitir nuevamente.

Cualquier inconveniente que presente nos informa por favor";
        Notify::whatapi('certiactivo', $solicitud->celularGlobal(), $mensaje);
        $mensaje = "Para firmar documentos PDF instale el siguiente programa

Para computador:
https://www.firmadigital.gob.ec/descargar-firmaec/

Para celular:
https://www.firmadigital.gob.ec/firmaec-movil/

Tutorial para el computador
https://www.youtube.com/watch?v=QnBdX4FFTEM

Tutorial para móvil
https://www.youtube.com/watch?v=t4vN4UGXDQs

Tutorial para Facturador SRI
https://www.youtube.com/watch?v=e_Y7Eu_lMUA
";
        Notify::whatapi('certiactivo', $solicitud->celularGlobal(), $mensaje);
    }


    public static function checkAllStatus()
    {

        $uRequests = UanatacaRequest::whereIn('estado', [
                EstadoSolicitud::$NUEVO,
                EstadoSolicitud::$ASIGNADO,
                EstadoSolicitud::$EN_VALIDACION,
            ]
        )
             ->where('signature_request_id', '!=',
                null
            )
            ->get();
        foreach ($uRequests as $uRequest) {
            try {
                UanatacaFacade::checkStatus($uRequest->signature_request_id);
            } catch (\Exception $e) {
            }
        }
    }
}
