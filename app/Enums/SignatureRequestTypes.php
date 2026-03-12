<?php

namespace App\Enums;

use App\Helpers\Uanataca\Enum\TipoSolicitud;
use App\Helpers\Uanataca\Enum\TipoSolicitudConsulta;

class SignatureRequestTypes
{
    public static $P_NATURAL = 'pnatural';
    public static $REPRESENTANTE_EMPRESA = 'rempresa';
    public static $M_EMPRESA = 'mempresa';
    public static $STR=[
      'pnatural'=>'Persona Natural',
      'rempresa'=>'Representante de Empresa',
      'mempresa'=>'Miembro de Empresa',
    ];

    public static function uanatacaType()
    {
        return [
            self::$P_NATURAL => TipoSolicitud::$PERSONA_NATURAL,
            self::$REPRESENTANTE_EMPRESA => TipoSolicitud::$REPRESENTANTE_LEGAL,
            self::$M_EMPRESA => TipoSolicitud::$MIEMBRO_EMPRESA,
        ];
    }
    public static function uanatacaTypeQuery()
    {
        return [
            self::$P_NATURAL => TipoSolicitudConsulta::$PERSONA_NATURAL,
            self::$REPRESENTANTE_EMPRESA => TipoSolicitudConsulta::$REPRESENTANTE_LEGAL,
            self::$M_EMPRESA => TipoSolicitudConsulta::$MIEMBRO_EMPRESA,
        ];
    }

}
