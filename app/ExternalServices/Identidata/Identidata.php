<?php

namespace App\ExternalServices\Identidata;

use App\ExternalServices\Identidata\DTO\PersonData;
use App\ExternalServices\Identidata\Exceptions\NetworkException;
use App\ExternalServices\Identidata\Exceptions\NotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Identidata
{
    protected $apiKey;
    protected $endpoint;

    /**
     * @param $apiKey
     * @param string $enhpoint
     */
    public function __construct($apiKey, string $enhpoint = 'https://identidata.gusof.com/api')
    {
        $this->apiKey = $apiKey;
        $this->endpoint = $enhpoint;
    }

    /**
     * @throws GuzzleException
     * @throws NetworkException
     * @throws NotFoundException
     */
    public function queryCedula(string $cedula): PersonData
    {

        $client = new Client();
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ];
        $response = $client->get($this->endpoint . '/cedula/?identification=' . $cedula, [
            'headers' => $headers
        ]);
        $body = $response->getBody()->getContents();

        $data = json_decode($body, 1);
        if (isset($data['status'])) {
            if ($data['status'] == 'not_found') {
                throw new NotFoundException();
            }
            if ($data['status'] == 'success') {
                return new PersonData($data['data']);
            }
        }
        throw new NetworkException($body);
    }

}