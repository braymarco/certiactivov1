<?php

namespace App\Services;

use OpenAI;
use OpenAI\Client;
use RuntimeException;

class Dashscope
{
    private const MIN_PIXELS = 32 * 32 * 1024;
    private const MAX_PIXELS = 32 * 32 * 2048;
    private const DEFAULT_MODEL = 'qwen-vl-ocr';

    private const CEDULA_MESSAGE = "Analiza las imágenes del documento de identidad ecuatoriano y extrae la siguiente
    información:

    1. Primera imagen (usa EXCLUSIVAMENTE esta imagen para estos datos):
    - Número de cédula.
    - Fecha de nacimiento

    2. Segunda imagen (usa EXCLUSIVAMENTE esta imagen para estos datos):
    - Código dactilar

    Devuelve únicamente el resultado en formato JSON con la siguiente estructura:

    {
      \"numeroCedula\": \"\",
      \"fechaNacimiento\": \"\",
      \"codigoDactilar\": \"\"
    }

    Reglas:
    - El código dactilar debe tener exactamente 10 caracteres alfanuméricos con el patron letra con 4 números mas letra
    con 4 números.
    - No agregues explicaciones ni texto adicional.";

    public static function instance(): Client
    {
        return OpenAI::factory()
            ->withApiKey(config('ai.providers.dashscope.key'))
            ->withBaseUri(config('ai.providers.dashscope.url'))
            ->make();
    }

    public static function ocr(string $b64Front, string $b64Back): array
    {
        $content = [
            self::buildImageContent($b64Front),
            self::buildImageContent($b64Back),
            ['type' => 'text', 'text' => self::CEDULA_MESSAGE],
        ];

        $response = self::instance()->chat()->create([
            'model' => self::DEFAULT_MODEL,
            'messages' => [
                ['role' => 'user', 'content' => $content],
            ],
        ]);

        $raw = $response->choices[0]->message->content;

        $clean = preg_replace('/```json|```/', '', $raw);
        $data = json_decode(trim($clean), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Respuesta inválida del modelo: {$raw}");
        }

        return $data;
    }

    private static function buildImageContent(string $base64Image): array
    {
        return [
            'type' => 'image_url',
            'image_url' => ['url' => "data:image/png;base64,{$base64Image}"],
            'min_pixels' => self::MIN_PIXELS,
            'max_pixels' => self::MAX_PIXELS,
        ];
    }
}
