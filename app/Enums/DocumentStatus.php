<?php

namespace App\Enums;

class DocumentStatus
{
    public static $CREATED = 1;
    public static $APPROVED = 2;
    public static $NEED_UPDATE = 3;
    public static $UPDATED = 4;

    public static $STR = [
        1 => 'CREADO',
        2 => 'APROBADO',
        3 => 'NECESITA ACTUALIZACIÓN',
        4 => 'ACTUALIZADO',
    ];
}
