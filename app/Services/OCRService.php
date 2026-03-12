<?php

namespace App\Services;

use App\ExternalServices\Identidata\Identidata;
use App\ExternalServices\Identidata\DTO\PersonData;
use App\Models\SignatureRequest;
use App\Enums\DocumentTypes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Throwable;

class OCRService
{
    public static function verifySignatureRequest(SignatureRequest $signatureRequest): bool
    {
        // 1. Identidata
        $personData = self::fetchIdentidata($signatureRequest->nro_documento);

        if ($personData !== null) {
            $birthdateRequest = Carbon::parse($signatureRequest->fecha_nacimiento)->toDateString();
            $birthdateIdentidata = Carbon::parse($personData->birthdate)->toDateString();
            $nombreRequest = Str::lower(trim("$signatureRequest->nombres $signatureRequest->apellido1 $signatureRequest->apellido2"));
            $nombreIdentidata = Str::lower(trim($personData->fullName));

            dump([
                'identidata' => [
                    'birthdateRequest' => $birthdateRequest,
                    'birthdateIdentidata' => $birthdateIdentidata,
                    'nombreRequest' => $nombreRequest,
                    'nombreIdentidata' => $nombreIdentidata,
                ],
            ]);

            if ($birthdateIdentidata !== $birthdateRequest) {
                $signatureRequest->histories()->create([
                    'message' => 'La fecha de nacimiento no coincide por favor revisela.',
                ]);
                return false;
            }

            $palabrasRequest = array_filter(explode(' ', $nombreRequest));
            $palabrasIdentidata = array_filter(explode(' ', $nombreIdentidata));

            if (!empty(array_diff($palabrasRequest, $palabrasIdentidata))) {
                $signatureRequest->histories()->create([
                    'message' => "El nombre parece estar mal escrito. "
                        . "Registrado: '$nombreRequest', Identidata: '$nombreIdentidata'.",
                ]);
                return false;
            }
        }

        // 2. OCR
        $documentFro = $signatureRequest->documents
            ->where('type', DocumentTypes::$CEDULA_FRONTAL)->first();

        $documentPos = $signatureRequest->documents
            ->where('type', DocumentTypes::$CEDULA_POSTERIOR)->first();

        if (!$documentFro || !$documentPos) {
            $signatureRequest->histories()->create([
                'message' => 'No se encontraron los documentos de cédula (frontal/posterior).',
            ]);
            return false;
        }

        $ocr = Dashscope::ocr(
            base64_encode($documentFro->content()),
            base64_encode($documentPos->content())
        );
        $nroDocumento = preg_replace('/[^0-9]/', '', $ocr['numeroCedula']);
        $fechaRequest = Carbon::parse($signatureRequest->fecha_nacimiento)->toDateString();
        $fechaOcr = Carbon::parse($ocr['fechaNacimiento'])->toDateString();

        dump([
            'ocr' => [
                'nroDocumentoOcr' => $nroDocumento,
                'nroDocumentoRequest' => $signatureRequest->nro_documento,
                'fechaOcr' => $fechaOcr,
                'fechaRequest' => $fechaRequest,
                'codigoDactilarOcr' => $ocr['codigoDactilar'],
                'codigoDactilarRequest' => $signatureRequest->codigo_dactilar,
            ],
        ]);

        if ($nroDocumento !== $signatureRequest->nro_documento) {
            $signatureRequest->histories()->create([
                'message' => 'El número de cédula del OCR no coincide.',
            ]);
            return false;
        }

        if ($fechaOcr !== $fechaRequest) {
            $signatureRequest->histories()->create([
                'message' => "La fecha de nacimiento del OCR no coincide. "
                    . "OCR: '$fechaOcr', Registrada: '$fechaRequest'.",
            ]);
            return false;
        }

        if (!preg_match('/^[A-Z]\d{4}[A-Z]\d{4}$/i', $ocr['codigoDactilar'])) {
            $signatureRequest->histories()->create([
                'message' => "El código dactilar del OCR tiene un formato inválido: '{$ocr['codigoDactilar']}'.",
            ]);
            return false;
        }

        if (Str::lower($ocr['codigoDactilar']) !== Str::lower($signatureRequest->codigo_dactilar)) {
            $signatureRequest->histories()->create([
                'message' => "El código dactilar no coincide. "
                    . "OCR: '{$ocr['codigoDactilar']}', Registrado: '$signatureRequest->codigo_dactilar'.",
            ]);
            return false;
        }

        return true;
    }

    private static function fetchIdentidata(string $cedula): ?PersonData
    {
        try {
            $identidata = new Identidata(config('services.identidata.key'));
            return $identidata->queryCedula($cedula);
        } catch (Throwable) {
            return null;
        }
    }
}
