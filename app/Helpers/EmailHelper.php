<?php

namespace App\Helpers;

class EmailHelper
{
    static function extractPlainText(string $rawEmail): string
    {
        // Extraer el boundary (con o sin comillas)
        preg_match('/boundary=["\'"]?(.+?)["\'"]?\s*(?:\r?\n|$)/i', $rawEmail, $boundaryMatch);

        if (empty($boundaryMatch[1])) {
            return '';
        }

        $boundary = trim($boundaryMatch[1]);

        // Separar las partes del MIME
        $parts = explode('--' . $boundary, $rawEmail);

        foreach ($parts as $part) {
            // Buscar la parte text/plain
            if (!preg_match('/Content-Type:\s*text\/plain/i', $part)) {
                continue;
            }

            // Detectar encoding
            preg_match('/Content-Transfer-Encoding:\s*(.+?)[\r\n]/i', $part, $encodingMatch);
            $encoding = strtolower(trim($encodingMatch[1] ?? ''));

            // Separar headers del body (doble salto de línea \r\n\r\n o \n\n)
            preg_match('/\r?\n\r?\n(.+)/s', $part, $bodyMatch);

            if (empty($bodyMatch[1])) {
                continue;
            }

            $body = $bodyMatch[1];

            // Decodificar según el encoding
            $body = match ($encoding) {
                'quoted-printable' => quoted_printable_decode($body),
                'base64'           => base64_decode($body),
                default            => $body,
            };

            return trim($body);
        }

        return '';
    }
    static function extractEmailBody(string $plainText): string
    {

        if (preg_match('/\nHola /i', $plainText, $match, PREG_OFFSET_CAPTURE)) {
            $plainText = substr($plainText, $match[0][1] + 1);
        }
        // Cortar firma
        if (preg_match('/\nAtentamente,/i', $plainText, $match, PREG_OFFSET_CAPTURE)) {
            $plainText = substr($plainText, 0, $match[0][1]);
        }

        return trim($plainText);
    }

}
