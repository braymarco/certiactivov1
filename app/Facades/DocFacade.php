<?php

namespace App\Facades;

class DocFacade
{
    public static function route($signatureRequestId, $fileName)
    {
        return $signatureRequestId . "/" . $fileName;
    }

}
