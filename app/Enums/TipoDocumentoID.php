<?php

namespace App\Enums;

use App\Helpers\Uanataca\Enum\TipoDocumento;

class TipoDocumentoID
{
    public static $CEDULA = 1;
    public static $PASAPORTE = 2;
    public static $STR = [
        1 => 'CÉDULA',
        2 => 'PASAPORTE',
    ];

    public static function uanatacaType()
    {
        return [
            self::$CEDULA => TipoDocumento::$CEDULA,
            self::$PASAPORTE => TipoDocumento::$PASAPORTE,
        ];
    }
}
