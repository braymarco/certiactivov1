<?php

namespace App\Enums;

use App\Helpers\Uanataca\Enum\FormatoContenedor;

class FormatoFirma
{
    public static $ARCHIVO = 1;
    public static $TOKEN = 2;

    public static $STR = [
        1 => 'ARCHIVO',
        2 => 'TOKEN'
    ];

    public static function uanatacaType( )
    {
        return [
            self::$ARCHIVO => FormatoContenedor::$ARCHIVO_P12,
            self::$TOKEN => FormatoContenedor::$TOKEN,
        ];

    }
}
