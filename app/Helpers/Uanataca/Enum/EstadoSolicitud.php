<?php

namespace App\Helpers\Uanataca\Enum;

class EstadoSolicitud
{
    public static string $NUEVO = 'NUEVO';
    public static string $ASIGNADO = 'ASIGNADO';
    public static string $EN_VALIDACION = 'EN VALIDACION';
    public static string $RECHAZADO = 'RECHAZADO';
    public static string $ELIMINADO = 'ELIMINADO';
    public static string $APROBADO = 'APROBADO';
    public static string $EMITIVO_VALIDO = 'EMITIDO (VALIDO)';
    public static string $EMITIVO_SUSPENDIDO = 'EMITIDO (SUSPENDIDO)';
    public static string $EMITIVO_REVOCADO = 'EMITIDO (REVOCADO)';
    public static string $EMITIVO_CADUCADO = 'EMITIDO (CADUCADO)';
}
