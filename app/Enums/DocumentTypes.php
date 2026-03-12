<?php

namespace App\Enums;

class DocumentTypes
{
    public static $CEDULA_FRONTAL = 'CEDULA_FRONTAL';
    public static $CEDULA_POSTERIOR = 'CEDULA_POSTERIOR';
    public static $SELFIE = 'SELFIE';
    public static $DOCUMENTO_ADICIONAL = 'DOCUMENTO_ADICIONAL';
    public static $RUC = 'RUC';
    public static $COPIA_RUC = 'COPIA_RUC';
    //================================================
    public static $CONSTITUCION = 'CONSTITUCION'; //p2, Acto constitutivo
    public static $NOMBRAMIENTO_REPRESENTATE = 'NOMBRAMIENTO_REPRESENTATE';//p1, Razón de inscripción societaria nombramiento
    public static $ACEPTACION_NOMBRAMIENTO = 'ACEPTACION_NOMBRAMIENTO';//p1, Nombramiento SAS

    public static $CEDULA_REPRESENTANTE_LEGAL = 'CEDULA_REPRESENTANTE_LEGAL';
    public static $AUTORIZACION_REPRESENTANTE = 'AUTORIZACION_REPRESENTANTE';
    public static $VIDEO = 'VIDEO';

    public static function str()
    {
        return [
            DocumentTypes::$CEDULA_FRONTAL => "Foto del lado frontal de su cédula",
            DocumentTypes::$CEDULA_POSTERIOR => "Foto del lado posterior de su cédula",
            DocumentTypes::$SELFIE => "Foto selfie con su cédula",
            DocumentTypes::$RUC => "Ruc",
            DocumentTypes::$COPIA_RUC => "Copia del ruc de la empresa",
            DocumentTypes::$CONSTITUCION => "Constitución de la compañía",
            DocumentTypes::$NOMBRAMIENTO_REPRESENTATE => "Nombramiento del representante legal",
            DocumentTypes::$ACEPTACION_NOMBRAMIENTO => "Aceptación de nombramiento",
            DocumentTypes::$CEDULA_REPRESENTANTE_LEGAL => "Cédula del representante legal",
            DocumentTypes::$AUTORIZACION_REPRESENTANTE => "Autorización del representante",
            DocumentTypes::$DOCUMENTO_ADICIONAL => "Documento adicional",
            DocumentTypes::$VIDEO => "Video",
        ];
    }

    public static function mimes()
    {
        return [
            DocumentTypes::$CEDULA_FRONTAL => 'jpg,jpeg,png',
            DocumentTypes::$CEDULA_POSTERIOR => 'jpg,jpeg,png',
            DocumentTypes::$SELFIE => 'jpg,jpeg,png',
            DocumentTypes::$RUC => "pdf",
            DocumentTypes::$COPIA_RUC => "pdf",
            DocumentTypes::$CONSTITUCION => "pdf",
            DocumentTypes::$NOMBRAMIENTO_REPRESENTATE => "pdf",
            DocumentTypes::$ACEPTACION_NOMBRAMIENTO => "pdf",
            DocumentTypes::$CEDULA_REPRESENTANTE_LEGAL => "pdf",
            DocumentTypes::$AUTORIZACION_REPRESENTANTE => "pdf",
            DocumentTypes::$DOCUMENTO_ADICIONAL => "pdf",
            DocumentTypes::$VIDEO => "mp4",
        ];
    }

    public static function porTipoSolicitud(): array
    {
        return [
            SignatureRequestTypes::$P_NATURAL => [
                DocumentTypes::$CEDULA_FRONTAL,
                DocumentTypes::$CEDULA_POSTERIOR,
                DocumentTypes::$SELFIE,
                DocumentTypes::$RUC,
                DocumentTypes::$DOCUMENTO_ADICIONAL,
            ],
            SignatureRequestTypes::$REPRESENTANTE_EMPRESA => [
                DocumentTypes::$CEDULA_FRONTAL,
                DocumentTypes::$CEDULA_POSTERIOR,
                DocumentTypes::$SELFIE,
                DocumentTypes::$RUC,
                DocumentTypes::$CONSTITUCION,
                DocumentTypes::$NOMBRAMIENTO_REPRESENTATE,
                DocumentTypes::$ACEPTACION_NOMBRAMIENTO,
                DocumentTypes::$DOCUMENTO_ADICIONAL,
            ],
            SignatureRequestTypes::$M_EMPRESA => [
                DocumentTypes::$CEDULA_FRONTAL,
                DocumentTypes::$CEDULA_POSTERIOR,
                DocumentTypes::$SELFIE,
                DocumentTypes::$COPIA_RUC,
                DocumentTypes::$CONSTITUCION,
                DocumentTypes::$NOMBRAMIENTO_REPRESENTATE,
                DocumentTypes::$ACEPTACION_NOMBRAMIENTO,
                DocumentTypes::$CEDULA_REPRESENTANTE_LEGAL,
                DocumentTypes::$AUTORIZACION_REPRESENTANTE,
                DocumentTypes::$DOCUMENTO_ADICIONAL,
            ],
        ];
    }
    public static function porTipoSolicitudRequired(): array
    {
        return [
            SignatureRequestTypes::$P_NATURAL => [
                DocumentTypes::$CEDULA_FRONTAL,
                DocumentTypes::$CEDULA_POSTERIOR,
                DocumentTypes::$SELFIE,
            ],
            SignatureRequestTypes::$REPRESENTANTE_EMPRESA => [
                DocumentTypes::$CEDULA_FRONTAL,
                DocumentTypes::$CEDULA_POSTERIOR,
                DocumentTypes::$SELFIE,
                DocumentTypes::$RUC,
                DocumentTypes::$CONSTITUCION,
                DocumentTypes::$NOMBRAMIENTO_REPRESENTATE,
                DocumentTypes::$ACEPTACION_NOMBRAMIENTO,
            ],
            SignatureRequestTypes::$M_EMPRESA => [
                DocumentTypes::$CEDULA_FRONTAL,
                DocumentTypes::$CEDULA_POSTERIOR,
                DocumentTypes::$SELFIE,
                DocumentTypes::$COPIA_RUC,
                DocumentTypes::$CONSTITUCION,
                DocumentTypes::$NOMBRAMIENTO_REPRESENTATE,
                DocumentTypes::$ACEPTACION_NOMBRAMIENTO,
                DocumentTypes::$CEDULA_REPRESENTANTE_LEGAL,
                DocumentTypes::$AUTORIZACION_REPRESENTANTE,
            ],
        ];
    }

    public static function variablesPorTipoSolicitud()
    {
        return [
            SignatureRequestTypes::$P_NATURAL => [

            ],
            SignatureRequestTypes::$REPRESENTANTE_EMPRESA => [
                'nro_ruc' => 'required',
                'empresa' => 'required',
                'cargo' => 'required',
            ],
            SignatureRequestTypes::$M_EMPRESA => [
                'nro_ruc' => 'required',
                'empresa' => 'required',
                'unidad' => 'required',
                'cargo' => 'required',

                'tipo_documento_rl' => 'required',
                'nro_documento_rl' => 'required',
                'nombres_rl' => 'required',
                'apellido1_rl' => 'required',
                'apellido2_rl' => 'required',

            ],
        ];
    }

}
