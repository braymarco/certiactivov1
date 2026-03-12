<?php

namespace App\Helpers\Uanataca\Interfaces;

use Carbon\Carbon;

class ConsultaEstadoResponse
{

    public ?string $message;
    /**
     * @var ConsultaSolicitudResponse[]
     */
    public array $data = [];
    public bool $result;

    public function __construct($arrData)
    {
        if (isset($arrData['data'], $arrData['data']['solicitudes'])) {

            $solicitudes = $arrData['data']['solicitudes'];
            foreach ($solicitudes as $solicitud) {
                $this->data[] = new ConsultaSolicitudResponse($solicitud);
            }
            unset($arrData['data']);
        }
        foreach ($arrData as $key => $value)
            $this->$key = $value;
    }


}

class ConsultaSolicitudResponse
{
    //El tipo de solicitud.
    public ?string $tipo_solicitud;
    /*
NUEVO	La solicitud ha sido ingresada y aún no ha sido revisada.
ASIGNADO	La solicitud ha sido asignada a un operador de registro para su verificación.
EN VALIDACION	La solicitud está siendo revisada por un operador de registro.
RECHAZADO	La solicitud ha sido rechazada.
ELIMINADO	La solicitud ha sido eliminada.
APROBADO	La solicitud ha sido aprobada y está en espera de que el firmante asigne su clave o PIN.
EMITIDO (VALIDO)	El firmante ha definido su clave o pin.
El certificado de firma electrónica es válido y puede ser utilizado.
EMITIDO (SUSPENDIDO)	El certificado ha sido suspendido, no se lo puede utilizar por el momento.
EMITIDO (REVOCADO)	El certificado ha sido invalidado, no se lo puede volver a utilizar.
EMITIDO (CADUCADO)	El certificado caducó, no se lo puede volver a utilizar.
     */
    public ?string $estado;
    //Las observaciones que hicieron a su sulicitud.
    public ?string $observacion;
    //Tipo de documento de identidad.
    public ?string $documento_tipo;
    //Número de documento de identidad.
    public ?string $documento;
    //Nombre completo del firmante o la Razón Social de la persona jurídica.
    public ?string $nombre_completo;
    //Tiempo de validez solicitada.
    public ?string $validez;
    //Código único de la solicitud.
    public ?string $uid;
    //Usuario que creó la solicitud.
    public ?string $creado_por;
    //Fecha en la que se creó la solicitud.
    public ?string $fecha_registro;

    public function fechaRegistro(): ?Carbon
    {
        if ($this->fecha_registro == null)
            return null;
        return Carbon::createFromTimeString($this->fecha_registro);
    }

    public function __construct($arrData)
    {

        foreach ($arrData as $key => $value)
            $this->$key = $value;
    }
}
