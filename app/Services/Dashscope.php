<?php

namespace App\Services;

use OpenAI;
use OpenAI\Client;

class Dashscope
{
    public static function instance(): Client
    {
        return OpenAI::factory()
            ->withApiKey(config('ai.providers.dashscope.key'))
            ->withBaseUri(config('ai.providers.dashscope.url'))->make();
    }

    public static function ocr(string $base64Image, string $message): string
    {
        $dashscope = self::instance();
        $response = $dashscope->chat()->create([
            'model' => 'qwen-vl-ocr',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                       
                        [
                            "type" => "image_url",
                            "image_url" => [
                                "url" => "data:image/png;base64," . $base64Image,
                            ],
                            // The minimum pixel threshold for the input image. If the image has fewer pixels than this value, it is enlarged until its total pixel count exceeds min_pixels.
                             "min_pixels" => 32 * 32 * 1024,
                            // The maximum pixel threshold for the input image. If the image has more pixels than this value, it is reduced until its total pixel count is below max_pixels.

                           "max_pixels" => 32 * 32 * 2048
                        ],
                    ]
                ],

            ]
        ]);
        return $response->choices[0]->message->content;
    }

}
