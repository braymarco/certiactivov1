<?php

namespace App\Http\Controllers;

use App\ExternalServices\Identidata\Exceptions\NetworkException;
use App\ExternalServices\Identidata\Exceptions\NotFoundException;
use App\ExternalServices\Identidata\Identidata;

use App\Models\PurchaseToken;
use Aws\Rekognition\RekognitionClient;
use Aws\Textract\TextractClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class PurchaseTokenController extends Controller
{
    public function main($purchaseToken)
    {
        $purchaseTokenFound = PurchaseToken::where('token', $purchaseToken)->first();
        if ($purchaseTokenFound == null)
            return "Link Inválido";

        return view("purchase_token");

    }



    public function verifya()
    {
        $this->request->validate([
            'identification_front' => 'required|file|mimes:png,jpeg,jpg',
            'identification_back' => 'required|file|mimes:png,jpeg,jpg',
            'selfie' => 'required|file|mimes:png,jpeg,jpg',
        ]);
        $file = $this->request->file('identification_front');
        $pathImg = $file->getRealPath();
    }

    public function verify()
    {
        $this->request->validate([
            'identification_front' => 'required|file|mimes:png,jpeg,jpg',
            'identification_back' => 'required|file|mimes:png,jpeg,jpg',
            //'selfie' => 'required|file|mimes:png,jpeg,jpg',
        ]);
        $file = $this->request->file('identification_front');
        $file2 = $this->request->file('identification_back');
        $pathImg = $file->getRealPath();
        $pathImg2 = $file->getRealPath();

        /*
                $clientTextract = new TextractClient([
                    'version' => 'latest',
                    'region' => config('services.aws.region'),
                    'credentials' => [
                        'key' => config('services.aws.credentials.key'),
                        'secret' => config('services.aws.credentials.secret'),
                    ],
                ]);


                // The file in this project.
                $file = fopen($pathImg, "rb");
                $contents = fread($file, filesize($pathImg));
                fclose($file);
                $file2 = fopen($pathImg2, "rb");
                $contents2 = fread($file2, filesize($pathImg2));
                fclose($file2);
                $options = [
                    'DocumentPages' => [
                        [
                            'Bytes' => $contents
                        ],
                        [
                            'Bytes' => $contents2
                        ]
                    ],

                ];

                $result = $clientTextract->analyzeID($options);
                echo print_r($result, true);


                die();*/

        $client = new RekognitionClient([
            'version' => 'latest',
            'region' => config('services.aws.region'),
            'credentials' => [
                'key' => config('services.aws.credentials.key'),
                'secret' => config('services.aws.credentials.secret'),
            ],
        ]);
        $result = $client->detectText([
            'Image' => [
                'Bytes' => file_get_contents($pathImg),
            ],
        ]);
        // Obtén los bloques de texto detectados ordenados por su posición vertical
        $blocks = $result['TextDetections'];
        usort($blocks, function ($a, $b) {
            return $a['Geometry']['BoundingBox']['Top'] <=> $b['Geometry']['BoundingBox']['Top'];
        });

// Crea una variable para almacenar el contenido ordenado
        $contenidoOrdenado = '';

// Recorre los bloques de texto y concatena su contenido
        foreach ($blocks as $block) {
            // Verifica si el bloque es una palabra o una línea de texto
            if ($block['Type'] === 'WORD') {
                $contenidoOrdenado .= $block['DetectedText'] . ' ';
            } elseif ($block['Type'] === 'LINE') {
                $contenidoOrdenado .= $block['DetectedText'] . "\n";
            }
        }

        echo $contenidoOrdenado;
        /*// Imprime el contenido ordenado
                $data= "Organiza esta información en formato json: nombres, apellidos, número de cédula (cedula), fecha de nacimiento (nacimiento), nacionalidad, sexo, lugar de nacimiento (provincia, canton, direccion). Datos:".$contenidoOrdenado;

                $result = OpenAI::chat()->create([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $data],
                    ],
                ]);

                echo $result->choices[0]->message->content; // Hello! How can I assist you today?*/
    }
}
