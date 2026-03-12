<?php

namespace App\Enums;

class SignatureRequestStatus
{
    public static $CREATED = 0;
    public static $IN_REVIEW = 1;
    public static $DOCUMENT_CHANGE = 2;
    public static $ISSUED = 3;
    public static $DELETED = 4;
    public static $APPROVED_REQUIREMENTS = 5;
    public static $SENDING_PROVIDER = 6; //se envía al proveedor
    public static $ERROR_PROCESSING = 7; //error al enviar al proveedor
    public static $SENT_SUPPLIER = 8; //enviado al proveedor
    public static $ASSIGNED_SUPPLIER = 9; //esperando actualización del proveedor
    public static $NOTFOUND_SUPPLIER = 10; //esperando actualización del proveedor
    public static $ERROR_SENDING_SUPPLIER = 11; //error que se produjo antes de enviar


    public static $STR_LOCAL = [
        'CREADO',
        'EN REVISIÓN',
        'ESPERANDO CAMBIO DE DOCUMENTACIÓN',
        'EMITIDA',
        'ELIMINADA',
        'REQUISITOS VALIDADOS',
        'GENERANDO FIRMA',
        'ERROR AL GENERAR FIRMA',
        'ENVIADO AL PROVEEDOR',
        'PROVEEDOR ASIGNADO',
        'NO ENCONTRADO DONDE EL PROVEEDOR',
        'ERROR AL ENVIAR AL PROVEEDOR',
    ];
    public static $STR = [
        'CREADO',
        'EN REVISIÓN',
        'ESPERANDO CAMBIO DE DOCUMENTACIÓN',
        'EMITIDA',
        'ELIMINADA',
        'REQUISITOS VALIDADOS',
        'GENERANDO FIRMA',
        'GENERANDO FIRMA',
        'GENERANDO FIRMA',
        'GENERANDO FIRMA',
        'GENERANDO FIRMA',
        'GENERANDO FIRMA',
    ];

}
