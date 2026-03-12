<?php

namespace App\Facades;

use App\Enums\DocumentTypes;
use App\Enums\SignatureRequestStatus;
use App\Enums\SignatureRequestTypes;
use App\Enums\TipoDocumentoID;
use App\Exceptions\ExistProviderRequestException;
use App\Exceptions\NotFoundException;
use App\Enums\FormatoFirma;
use App\Exceptions\SyncException;
use App\Helpers\Uanataca\Enum\EstadoSolicitud;
use App\Helpers\Uanataca\Exceptions\ClientException;
use App\Helpers\Uanataca\Exceptions\ForbiddenException;
use App\Helpers\Uanataca\Exceptions\MethodNotAllowedException;
use App\Helpers\Uanataca\Exceptions\ServerException;
use App\Helpers\Uanataca\Exceptions\UnauthorizedException;
use App\Helpers\Uanataca\Interfaces\ConsultaEstadoResponse;
use App\Helpers\Uanataca\Interfaces\SolicitudResponse;
use App\Helpers\Uanataca\Uanataca;
use App\Jobs\CheckRequest;
use App\Models\Cliente;
use App\Models\SignatureRequest;
use App\Models\UanatacaRequest;
use Carbon\Carbon;

class UanatacaFacade
{

    public static function instance(): Uanataca
    {
        $apiKey = config('services.uanataca.apiKey');
        $uid = config('services.uanataca.uid');
        return new Uanataca($apiKey, $uid);
    }


    /**
     * @throws MethodNotAllowedException
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws ServerException
     * @throws ClientException
     * @throws ExistProviderRequestException
     * @throws SyncException
     */
    public static function sendRequest($requestID): SolicitudResponse
    {
        $uanatacaR = UanatacaRequest::where('signature_request_id', $requestID)->first();
        if ($uanatacaR !== null) {
            throw new ExistProviderRequestException("Esta firma ya fue enviada");
        }
        $sRequest = SignatureRequest::find($requestID);
        if ($sRequest === null)
            throw new NotFoundException("SignatureRequest no encontrada");
        $requisitos = $sRequest->requisitosActivos();
        if (!isset(
            $requisitos[DocumentTypes::$CEDULA_FRONTAL],
            $requisitos[DocumentTypes::$CEDULA_POSTERIOR],
            $requisitos[DocumentTypes::$SELFIE],
        )) {
            throw new NotFoundException("Requisitos no encontrados");
        }

        $requisitosb64 = array_map(function ($requisito) {
            return base64_encode($requisito->content());
        }, $requisitos);
        $tipoSolicitudUanataca = SignatureRequestTypes::uanatacaType()[$sRequest->tipo];
        $numeroDocumento = $sRequest->nro_documento;
        $commonFields = [
            "tipo_solicitud" => $tipoSolicitudUanataca,
            "contenedor" => FormatoFirma::uanatacaType()[$sRequest->formato],
            "serial_token" => $sRequest->sn_token,
            "nombres" => $sRequest->nombres,
            "apellido1" => $sRequest->apellido1,
            "apellido2" => $sRequest->apellido2,
            "tipodocumento" => TipoDocumentoID::uanatacaType()[$sRequest->tipo_documento],
            "numerodocumento" => $numeroDocumento,
            "coddactilar" => $sRequest->codigo_dactilar,
            "sexo" => $sRequest->sexo,
            "fecha_nacimiento" => date("Y/m/d", strtotime($sRequest->fecha_nacimiento)),
            "nacionalidad" => $sRequest->nacionalidad,
            "telfCelular" => $sRequest->celular,
            //"telfFijo" => '',
            "eMail" => $sRequest->email,
            //"telfCelular2" => $sRequest->celular2,
            //"eMail2" => $sRequest->email2,

            "provincia" => $sRequest->provincia->nombre,
            "ciudad" => $sRequest->canton->nombre,
            "direccion" => $sRequest->direccion,
            //"IdAgenteMovil" => "",
            "vigenciafirma" => $sRequest->plan->uanataca_id,
            //"coddescuento" => "",
            "f_cedulaFront" => $requisitosb64[DocumentTypes::$CEDULA_FRONTAL],
            "f_cedulaBack" => $requisitosb64[DocumentTypes::$CEDULA_POSTERIOR],
            "f_selfie" => $requisitosb64[DocumentTypes::$SELFIE],


        ];
        if (
            $sRequest->tipo == SignatureRequestTypes::$M_EMPRESA
            ||
            $sRequest->tipo == SignatureRequestTypes::$REPRESENTANTE_EMPRESA
        ) {
            $commonFields['f_copiaruc'] = $requisitosb64[DocumentTypes::$RUC];

        } else {
            if ($sRequest->con_ruc && isset($requisitosb64[DocumentTypes::$RUC]))
                $commonFields['f_copiaruc'] = $requisitosb64[DocumentTypes::$RUC];
        }


        if (isset($requisitosb64[DocumentTypes::$VIDEO]))
            $commonFields['f_adicional1'] = $requisitosb64[DocumentTypes::$VIDEO];
        if (isset($requisitosb64[DocumentTypes::$DOCUMENTO_ADICIONAL]))
            $commonFields['f_adicional2'] = $requisitosb64[DocumentTypes::$DOCUMENTO_ADICIONAL];

        $additionalFields = [];
        switch ($sRequest->tipo) {
            case SignatureRequestTypes::$P_NATURAL:
                if ($sRequest->con_ruc) {
                    $additionalFields['ruc_personal'] = $sRequest->nro_ruc;
                }
                break;
            case SignatureRequestTypes::$M_EMPRESA:
                if (!isset(
                    $requisitosb64[DocumentTypes::$NOMBRAMIENTO_REPRESENTATE],
                    $requisitosb64[DocumentTypes::$ACEPTACION_NOMBRAMIENTO],
                    $requisitosb64[DocumentTypes::$CONSTITUCION],
                    $requisitosb64[DocumentTypes::$CEDULA_REPRESENTANTE_LEGAL],
                    $requisitosb64[DocumentTypes::$AUTORIZACION_REPRESENTANTE],
                ))
                    throw new NotFoundException("Requisitos no encontrados");
                $additionalFields = [
                    "empresa" => $sRequest->empresa,
                    "ruc_empresa" => $sRequest->nro_ruc,
                    "cargo" => $sRequest->cargo,


                    "motivo" => "",//
                    "unidad" => $sRequest->unidad,
                    "nombresRL" => $sRequest->nombres_rl,
                    "apellidosRL" => $sRequest->apellido1_rl,
                    "tipodocumentoRL" => TipoDocumentoID::uanatacaType()[$sRequest->tipo_documento_rl],
                    "numerodocumentoRL" => $sRequest->nro_documento_rl,
                    "f_nombramiento" => $requisitosb64[DocumentTypes::$NOMBRAMIENTO_REPRESENTATE],
                    "f_nombramiento2" => $requisitosb64[DocumentTypes::$ACEPTACION_NOMBRAMIENTO],
                    "f_constitucion" => $requisitosb64[DocumentTypes::$CONSTITUCION],
                    "f_documentoRL" => $requisitosb64[DocumentTypes::$CEDULA_REPRESENTANTE_LEGAL],
                    "f_autreprelegal" => $requisitosb64[DocumentTypes::$AUTORIZACION_REPRESENTANTE]
                ];
                break;
            case SignatureRequestTypes::$REPRESENTANTE_EMPRESA:
                $additionalFields = [
                    "empresa" => $sRequest->empresa,
                    "ruc_empresa" => $sRequest->nro_ruc,
                    "cargo" => $sRequest->cargo,
                    "f_nombramiento" => $requisitosb64[DocumentTypes::$NOMBRAMIENTO_REPRESENTATE],
                    "f_nombramiento2" => $requisitosb64[DocumentTypes::$ACEPTACION_NOMBRAMIENTO],
                    "f_constitucion" => $requisitosb64[DocumentTypes::$CONSTITUCION],
                ];
                break;
            default:
        }
        $uanataca = self::instance();
        $data = array_merge($commonFields, $additionalFields);
        //consultamos solicitudes con esta identificación para evitar duplicados
        $tipoSolicitudUanatacaConsulta = SignatureRequestTypes::uanatacaTypeQuery()[$sRequest->tipo];

        try {
            self::syncUanatacaRequests($numeroDocumento, $tipoSolicitudUanatacaConsulta);
        } catch (\Exception $e) {
            \Log::error("syncUanatacaRequests error " . $e->getMessage());
            throw new SyncException($e->getMessage());
        }


        $sRequest->update([
            'estado' => SignatureRequestStatus::$SENDING_PROVIDER
        ]);

        try {
            $solicitud = $uanataca->solicitud($data, true);
        } catch (ForbiddenException|MethodNotAllowedException|ServerException|UnauthorizedException $e) {
            $sRequest->update([
                'provider_response' => $e->getMessage(),
                'estado' => SignatureRequestStatus::$ERROR_PROCESSING
            ]);
            throw $e;
        } catch (ClientException $e) {
            $sRequest->update([
                'provider_response' => $e->getMessage(),
                'estado' => SignatureRequestStatus::$ERROR_SENDING_SUPPLIER
            ]);
        }


        $sRequest->update([
            'estado' => SignatureRequestStatus::$SENT_SUPPLIER,
            'provider_sended' => true
        ]);

        if ($solicitud->message !== null) {
            $sRequest->update([
                'provider_response' => $solicitud->message . "|" . $sRequest->provider_response
            ]);
        }
        if ($solicitud->response !== null) {
            $sRequest->update([
                'provider_response' => $solicitud->response . "|" . $sRequest->provider_response
            ]);
        }
        if ($solicitud->result) {
            if ($solicitud->token) {
                $tokenLike = substr($solicitud->token, 7);


                $consultaRes = $uanataca->consultarEstado($sRequest->nro_documento, $tipoSolicitudUanatacaConsulta);

                foreach ($consultaRes->data as $solicitudRes) {
                    if (str_contains($solicitudRes->uid, $tokenLike)) {
                        UanatacaRequest::create([
                            'signature_request_id' => $sRequest->id,
                            'uid' => $solicitudRes->uid,
                            'token' => $solicitud->token,
                            'estado' => $solicitudRes->estado,
                            'observacion' => $solicitudRes->observacion,
                            'documento' => $sRequest->nro_documento,
                            'documento_tipo' => $tipoSolicitudUanatacaConsulta
                        ]);
                        $sRequest->update([
                            'estado' => SignatureRequestStatus::$ASSIGNED_SUPPLIER
                        ]);
                        break;
                    }
                }

            }
        } else {
            $sRequest->update([
                'estado' => SignatureRequestStatus::$ERROR_SENDING_SUPPLIER
            ]);
        }

        return $solicitud;
    }

    /**
     * @throws MethodNotAllowedException
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws ServerException
     * @throws ClientException
     */
    public static function syncUanatacaRequests($numeroDocumento, $tipoSolicitudUanataca): void
    {
        $uanataca = self::instance();
        $solicitudesPrevias = $uanataca->consultarEstado($numeroDocumento, $tipoSolicitudUanataca);
        foreach ($solicitudesPrevias->data as $solicitudPrevia) {
            $uanatacaR = UanatacaRequest::where('uid', $solicitudPrevia->uid)->first();
            if ($uanatacaR === null) {
                \Log::notice("Request encontrado, sincronizando.. "
                    . $numeroDocumento . " " . $tipoSolicitudUanataca .
                    $solicitudPrevia->uid);
                UanatacaRequest::create([
                    'uid' => $solicitudPrevia->uid,
                    'documento' => $numeroDocumento,
                    'documento_tipo' => $tipoSolicitudUanataca,

                    'estado' => $solicitudPrevia->estado,
                    'observacion' => $solicitudPrevia->observacion,
                ]);
            }
        }
    }

    /**
     * @throws MethodNotAllowedException
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws ServerException
     * @throws ClientException
     */
    public static function asignarUanatacaRequest(SignatureRequest $sRequest)
    {
        $uReq = $sRequest->uanatacaRequestFirst();
        if ($uReq !== null)
            return $uReq;
        $tipoSolicitudUanatacaConsulta = SignatureRequestTypes::uanatacaTypeQuery()[$sRequest->tipo];
        $uanataca = self::instance();

        //revisamos requests que no tienen un signature
        $uReq = UanatacaRequest:: where('created_at', '>', $sRequest->created_at)
            ->where('documento', $sRequest->nro_documento)
            ->where('documento_tipo', $tipoSolicitudUanatacaConsulta)
            ->where('signature_request_id', null)
            ->orderBy('id', 'ASC')
            ->first();
        if ($uReq !== null) {
            $uReq->update([
                'signature_request_id' => $sRequest->id
            ]);
            return $uReq;
        }

        $solicitudes = $uanataca->consultarEstado($sRequest->nro_documento, $tipoSolicitudUanatacaConsulta);

        if (!$solicitudes->result)
            return null;
        $solicitudesRev = array_reverse($solicitudes->data);

        foreach ($solicitudesRev as $solicitud) {
            $uReq = UanatacaRequest::where('uid', $solicitud->uid)->first();

            //encuentra la primer request no agregada
            if ($uReq === null) {
                if ($solicitud->fechaRegistro() > $sRequest->created_at) {
                    $sRequest->update([
                        'estado' => SignatureRequestStatus::$ASSIGNED_SUPPLIER
                    ]);
                    return UanatacaRequest::create([
                        'signature_request_id' => $sRequest->id,
                        'uid' => $solicitud->uid,
                        'documento' => $sRequest->nro_documento,
                        'documento_tipo' => $tipoSolicitudUanatacaConsulta,
                        'estado' => $solicitud->estado,
                        'observacion' => $solicitud->observacion,
                    ]);
                }

            }


        }
        $sRequest->update([
            'estado' => SignatureRequestStatus::$ASSIGNED_SUPPLIER
        ]);
        \Log::error("No se encontró proveedor request de firma");
        return null;
    }


    /**
     * @throws MethodNotAllowedException
     * @throws ForbiddenException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws ServerException
     * @throws ClientException
     */
    public static function checkStatus($requestID)
    {
        $sRequest = SignatureRequest::find($requestID);
        if ($sRequest === null)
            throw new NotFoundException("SignatureRequest no encontrada");
        $uReq = $sRequest->uanatacaRequestFirst();
        if ($uReq === null) {
            $uReq = UanatacaFacade::asignarUanatacaRequest($sRequest);
            if ($uReq === null)
                return null;
        }
        $tipoSolicitudUanatacaConsulta = SignatureRequestTypes::uanatacaTypeQuery()[$sRequest->tipo];
        $uanataca = self::instance();
        $consultaRes = $uanataca->consultarEstado(
            $sRequest->nro_documento,
            $tipoSolicitudUanatacaConsulta
        );
        if ($consultaRes->result) {
            foreach ($consultaRes->data as $consulta) {
                if ($consulta->uid == $uReq->uid) {

                    $uReq->update([
                        'estado' => $consulta->estado,
                        'observacion' => $consulta->observacion,
                    ]);
                    if (
                        $sRequest->estado != SignatureRequestStatus::$ISSUED
                        && $uReq->estado == EstadoSolicitud::$APROBADO
                    ) {
                        Notify::notifyTelegram("Firma aprobada");
                        SignatureRequestFacade::solicitudAprobada($sRequest);
                    }
                    return $consulta->estado;
                }
            }
        }
        $sRequest->update([
            'estado' => SignatureRequestStatus::$NOTFOUND_SUPPLIER
        ]);
        return null;
    }


}
