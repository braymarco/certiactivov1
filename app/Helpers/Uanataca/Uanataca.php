<?php

namespace App\Helpers\Uanataca;

use App\Helpers\Uanataca\Exceptions\ClientException;
use App\Helpers\Uanataca\Exceptions\ForbiddenException;
use App\Helpers\Uanataca\Exceptions\MethodNotAllowedException;
use App\Helpers\Uanataca\Exceptions\ServerException;
use App\Helpers\Uanataca\Exceptions\UnauthorizedException;
use App\Helpers\Uanataca\Interfaces\ConsultaEstadoResponse;
use App\Helpers\Uanataca\Interfaces\SolicitudResponse;
use App\Models\ProviderRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Uanataca
{
    private string $urlAPI;
    private string $apiKey;
    private string $uid;

    /**
     * @param string $apiKey
     * @param string $uid
     */
    public function __construct(string $apiKey, string $uid, string $urlAPI = "https://api.uanataca.ec/v4")
    {
        $this->apiKey = $apiKey;
        $this->uid = $uid;
        $this->urlAPI = $urlAPI;
    }


    /**
     * @throws ServerException
     * @throws UnauthorizedException
     * @throws MethodNotAllowedException
     * @throws ForbiddenException
     * @throws ClientException
     */
    public function post(string $endpoint, array $data, $test = false)
    {
        $url = $this->urlAPI . $endpoint;

        $pRequest = ProviderRequest::create([
            'endpoint' => $url,
            'request_method' => 'POST',
            'request' => json_encode(array_map(function ($value) {
                return substr($value, 0, 50);
            }, $data)),
        ]);
        $client = new Client();
        $data['apikey'] = $this->apiKey;
        $data['uid'] = $this->uid;
        try {
            $res = $client->request('POST', $url, [
                'http_errors' => false,
                'json' => $data
            ]);
            $pRequest->response_status_code = $res->getStatusCode();
        } catch (ConnectException $e) {
            $pRequest->update([
                'exception' => $e->getMessage()
            ]);
            throw new  ClientException($e->getMessage());
        } catch (GuzzleException $e) {
            $pRequest->update([
                'exception' => $e->getMessage()
            ]);
            throw new  ServerException($e->getMessage());
        }
        $pRequestData = [
            'response_status_code' => $res->getStatusCode(),
            'response' => $res->getBody()
        ];
        if ($res->getStatusCode() !== ResponseAlias::HTTP_OK) {
            $pRequestData['exception'] = $res->getBody();
        }

        $pRequest->update($pRequestData);

        switch ($res->getStatusCode()) {
            case ResponseAlias::HTTP_OK:
                return json_decode($res->getBody(), 1);
            case ResponseAlias::HTTP_UNAUTHORIZED:
                throw new UnauthorizedException($res->getBody());
            case ResponseAlias::HTTP_FORBIDDEN:
                throw new ForbiddenException($res->getBody());
            case ResponseAlias::HTTP_METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException($res->getBody());
            default:
                throw new  ServerException($res->getBody());

        }

    }

    /**
     * @throws ForbiddenException
     * @throws MethodNotAllowedException
     * @throws UnauthorizedException
     * @throws ServerException
     * @throws ClientException
     */
    public function solicitud($data, $test = false): SolicitudResponse
    {
        $response = $this->post('/solicitud', $data, $test);
        return new SolicitudResponse($response);
    }

    /**
     * /**
     * @param $numeroDocumento
     * @param $tipoSolicitud
     *
     * @return ConsultaEstadoResponse
     * @throws ClientException
     * @throws ForbiddenException
     * @throws MethodNotAllowedException
     * @throws ServerException
     * @throws UnauthorizedException
     */
    public function consultarEstado($numeroDocumento, $tipoSolicitud): ConsultaEstadoResponse
    {
        $data = [
            'numerodocumento' => $numeroDocumento,
            'tipo_solicitud' => $tipoSolicitud,
        ];
        $response = $this->post('/consultarEstado', $data);
        return new ConsultaEstadoResponse($response);

    }


}
