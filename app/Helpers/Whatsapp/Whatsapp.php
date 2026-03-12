<?php

namespace App\Helpers\Whatsapp;

use App\Helpers\Whatsapp\Exceptions\RequestException;
use App\Helpers\Whatsapp\Models\MessageResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;

class Whatsapp
{
    private $endpoint;
    private $globalKey;

    /**
     * @param $endpoint
     * @param $globalKey
     */
    public function __construct($endpoint, $globalKey)
    {
        $this->endpoint = $endpoint;
        $this->globalKey = $globalKey;
    }

    /**
     * @throws RequestException
     */
    public function login($internationalPhone)
    {
        $client = new Client();
        try {
            $res = $client->request('GET',
                $this->endpoint . '/login?phone=' . $internationalPhone,
                [
                    'connect_timeout' => 5,
                    'headers' => [
                        'token' => $this->globalKey
                    ],
                ],


            );
            if ($res->getStatusCode() !== 200)
                return throw new RequestException("Hubo un error al realizar la petición. Código de respuesta: {$res->getStatusCode()}. " . $res->getBody());


            $bodyObj = json_decode($res->getBody());
            if (!isset($bodyObj->data))
                throw new RequestException($bodyObj->message);

            return $bodyObj->data;

        } catch (GuzzleException $e) {
            return throw new RequestException($e->getMessage());

        }
    }

    /**
     * @throws RequestException
     */
    public function getContacts($phoneToken)
    {
        $client = new Client();
        try {
            $res = $client->request('GET',
                $this->endpoint . '/chats/?token=' . $this->globalKey
                . '&phone_token=' . $phoneToken);
            if ($res->getStatusCode() !== 200)
                return throw new RequestException("Hubo un error al realizar la petición. Código de respuesta: {$res->getStatusCode()}. " . $res->getBody());


            $arr = json_decode($res->getBody(), 1);

            return $arr;

        } catch (GuzzleException $e) {
            return throw new RequestException($e->getMessage());

        }
    }

    /**
     * @throws RequestException
     */
    public function sendText($phoneToken, $phone, $text): MessageResponse
    {
        return $this->sendMessage($phoneToken, $phone, 'text', $text);

    }

    /**
     * @throws RequestException
     */
    public function sendTextGroup($phoneToken, $phone, $text): MessageResponse
    {
        return $this->sendMessage($phoneToken, $phone, 'group_text', $text);

    }

    /**
     * @throws RequestException
     */
    public function sendMedia($phoneToken, $phone, $body, $path, $type): MessageResponse
    {
        /* $fInfo = new finfo(FILEINFO_MIME);
         $mimeType = $fInfo->buffer($body);
         $mimeType = explode(';', $mimeType);
         // $body = base64_encode($body);
         $mimeType = trim($mimeType[0]);*/
        return $this->sendMessage($phoneToken, $phone, $path, $type);

    }

    /**
     * @param $phoneToken
     * @param $phoneTo
     * @param $file
     * @param string $type
     * @param string $text
     * @return MessageResponse
     * @throws RequestException
     */
    private function sendMessage($phoneToken, $phoneTo, string $type = 'text', string $text = '', $file = null): MessageResponse
    {
        //\Storage::put("a.txt",$body);

        $client = new Client();
        try {
            $multipart = [
                [
                    'name' => 'from',
                    'contents' => $phoneToken
                ],
                [
                    'name' => 'to',
                    'contents' => $phoneTo
                ],
                [
                    'name' => 'type',
                    'contents' => $type
                ],
                [
                    'name' => 'text',
                    'contents' => $text
                ],
            ];
            if ($type != 'text' && $type != 'group_text') {
                $multipart[] = [
                    'name' => 'file',
                    'contents' => Utils::tryFopen($file, 'r')
                ];
            }
            $res = $client->request('POST',
                $this->endpoint . '/messages',
                [
                    'connect_timeout' => 3.14,
                    'timeout' => 5,
                    'headers' => [
                        'token' => $this->globalKey
                    ],
                    'multipart' => $multipart
                ]


            );
            if ($res->getStatusCode() !== 200)
                return throw new RequestException("Hubo un error al realizar la petición. Código de respuesta: {$res->getStatusCode()}. " . $res->getBody());

            $bodyObj = json_decode($res->getBody());
            if (!isset($bodyObj->data))
                throw new RequestException($bodyObj->msg);

            return new MessageResponse($bodyObj);

        } catch (GuzzleException $e) {
            return throw new RequestException($e->getMessage());

        }
    }

}
