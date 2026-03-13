<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class Dashscope
{
    private const MIN_PIXELS = 32 * 32 * 3;
    private const MAX_PIXELS = 32 * 32 * 8192;
    private const DEFAULT_MODEL = 'qwen-vl-ocr';

    private const CEDULA_MESSAGE = "Please extract the following information from the two Ecuadorian ID card images.

    From IMAGE 1 (front of the ID card):
    - Extract: National ID number (numeroCedula) and date of birth (fechaNacimiento).

    From IMAGE 2 (back of the ID card):
    - Dactylar code (codigoDactilar)

    You must accurately extract the key information. Do not omit or fabricate information. Replace any single character that is blurry or obscured by strong light with an English question mark (?).

    Return the data in JSON format as follows:
    {
      \"numeroCedula\": \"xxx\",
      \"fechaNacimiento\": \"xxx\",
      \"codigoDactilar\": \"xxx\",
    }

    Additional rules:
    - numeroCedula must contain exactly 10 numeric digits with no dashes or spaces (example: 1800000089).
    - fechaNacimiento must be in YYYY-MM-DD format (example: 1991-09-02).
    - codigoDactilar must follow this exact pattern: 1 uppercase letter + 4 digits + 1 uppercase letter + 4 digits, total 10 characters (example: V9494V9898).
    - If a field is not found in the image, return null for that field.";

    private static function instance(): Client
    {
        return new Client([
            'base_uri' => config('ai.providers.dashscope.url'),
            'headers' => [
                'Authorization' => 'Bearer ' . config('ai.providers.dashscope.key'),
                'Content-Type' => 'application/json',
            ],
            'timeout' => 60,
        ]);
    }

    public static function ocr(string $frontRaw, string $backRaw): array
    {
        $content = [
            self::buildImageContent($frontRaw),
            self::buildImageContent($backRaw),
            ['type' => 'text', 'text' => self::CEDULA_MESSAGE],
        ];

        try {
            $response = self::instance()->post('chat/completions', [
                'json' => [
                    'model' => self::DEFAULT_MODEL,
                    'messages' => [
                        ['role' => 'user', 'content' => $content],
                    ],
                    'response_format' => ['type' => 'json_object'],
                ],
            ]);

            $raw = $response->getBody()->getContents();
            $body = json_decode($raw, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("Respuesta inválida del modelo: $raw");
            }

            $responseContent = $body['choices'][0]['message']['content'];
            $data = json_decode($responseContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("JSON inválido en el contenido: $responseContent");
            }

            return $data;

        } catch (GuzzleException $e) {
            throw new RuntimeException("Dashscope OCR request failed: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    private static function buildImageContent(string $rawContent): array
    {
        $mimeType = self::detectMimeType($rawContent);
        $base64 = base64_encode($rawContent);

        return [
            'type' => 'image_url',
            'image_url' => ['url' => "data:{$mimeType};base64,{$base64}"],
            'min_pixels' => self::MIN_PIXELS,
            'max_pixels' => self::MAX_PIXELS,
        ];
    }

    private static function detectMimeType(string $binary): string
    {
        return match (true) {
            str_starts_with($binary, "\xFF\xD8\xFF") => 'image/jpeg',
            str_starts_with($binary, "\x89PNG\r\n\x1a\n") => 'image/png',
            str_starts_with($binary, 'GIF87a'),
            str_starts_with($binary, 'GIF89a') => 'image/gif',
            str_starts_with($binary, "\x42\x4D") => 'image/bmp',
            default => 'image/jpeg',
        };
    }
}
