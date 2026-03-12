<?php

namespace App\Helpers\Uanataca\Interfaces;

class SolicitudResponse
{
    public ?string $message = null;
    public ?string $response = null;
    public ?string $token = null;
    public ?bool $result = true;

    public function __construct($arrData)
    {
        foreach ($arrData as $key => $value)
            $this->$key = $value;
    }
}
