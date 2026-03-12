<?php

namespace App\Http\Controllers;

use App\Facades\ConfigFacade;
use App\Facades\Notify;
use Aws\Textract\TextractClient;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;


class OrderController extends Controller
{


    private
    function getText($path)
    {
        $imageAnnotator = new ImageAnnotatorClient();

        $response = $imageAnnotator->textDetection($path);
        $texts = $response->getTextAnnotations();
        /*$a=[];
        foreach ($texts as $text) {
            $a[]=$text->getDescription();
        }
        var_dump($a); */

        $fullAnnotation = $response->getFullTextAnnotation()->getText();

        $imageAnnotator->close();
        return explode("\n", $fullAnnotation);
    }

    public
    function checkRequirementbas()
    {
        $form = $this->request->validate([
            'identification_front' => 'file|required|mimes:png,jpeg,jpg',
            'identification_back' => 'file|required|mimes:png,jpeg,jpg',
            'selfie' => 'file|required|mimes:png,jpeg,jpg',
        ]);

        $identificationFront = $this->request->file('identification_front')->getRealPath();
        $identificationBack = $this->request->file('identification_back')->getRealPath();

        $image = file_get_contents($identificationFront);
        $imageBack = file_get_contents($identificationBack);

        $lines = $this->getText($image);
        var_dump($lines);
        die();
        $linesBack = $this->getText($imageBack);


        $dataT = [];
        $identification = "";
        $nacimiento = "";
        $sexo = "";
        $apellidoA = "";
        $apellidoB = "";
        $nombres = "";
        $lugarNacimiento = "";
        $lugarNacimientoB = "";
        $codigoDactilar = "";
        $prev = "";

        foreach ($linesBack as $key => $text) {
            if (str_contains($text, 'DACTILAR')) {
                $codigoDactilar = $linesBack[$key + 1];
                $dactilarSplit = str_split($codigoDactilar);
                if ($dactilarSplit[5] === '1') {
                    $dactilarSplit[5] = 'I';
                }
                $codigoDactilar = implode('', $dactilarSplit);
                break;
            }
        }
        foreach ($lines as $key => $text) {

            $description = $text;
            if (str_contains($description, 'NUI.')) {
                $identification = str_replace('NUI.', '', $description);
            }
            if (str_contains($prev, 'FECHA')) {
                $end = str_split($nacimiento);
                $end = end($end);
                if (str_contains('-', $end)) {
                    $nacimiento = $end;
                }


            }
            if (str_contains($prev, 'SEXO')) {
                $sexo = $description;

            }
            if (str_contains($text, 'APELLIDOS NOMBRES')) {
                $apellidos = $lines[$key + 1];
                $apellidos = str_split($apellidos);
                $apellidoA = $apellidos[0];
                $apellidoB = $apellidos[1];

                $nombres = $lines[$key + 2];


            }

            if (str_contains($text, 'LUGAR DE NACIMIENTO')) {


                $lugarNacimiento = $lines[$key + 1];
                $lugarNacimientoB = $lines[$key + 2];

            }

            $prev = $description;

        }
        //$text = implode("\n", $dataT);
        $data = [
            "Cédula" => $identification,
            "Fecha de nacimiento" => $nacimiento,
            "Sexo" => $sexo,
            "Apellido 1" => $apellidoA,
            "Apellido 2" => $apellidoB,
            "Nombres" => $nombres,
            "Lugar Nacimiento" => $lugarNacimiento,
            "Direccion" => $lugarNacimientoB,
            "Codigo Dactilar" => $codigoDactilar,
        ];
        echo json_encode($data);


    }

    public
    function checkRequirement()
    {
        $form = $this->request->validate([
            'identification_front' => 'file|required|mimes:png,jpeg,jpg',
            'identification_back' => 'file|required|mimes:png,jpeg,jpg',
            'selfie' => 'file|required|mimes:png,jpeg,jpg',
        ]);

        $identificationFront = $this->request->file('identification_front')->getRealPath();
        $identificationBack = $this->request->file('identification_back')->getRealPath();

        $image = file_get_contents($identificationFront);
        $imageBack = file_get_contents($identificationBack);

        $linesBack = $this->getText($imageBack);

        $lines = $this->getText($image);


        $dataT = [];
        $identification = "";
        $nacimiento = "";
        $sexo = "";
        $apellidoA = "";
        $apellidoB = "";
        $nombres = "";
        $lugarNacimiento = "";
        $lugarNacimientoB = "";
        $codigoDactilar = "";
        $prev = "";

        foreach ($linesBack as $key => $text) {
            if (str_contains($text, 'DACTILAR')) {
                $codigoDactilar = $linesBack[$key + 1];
                $dactilarSplit = str_split($codigoDactilar);
                if ($dactilarSplit[5] === '1') {
                    $dactilarSplit[5] = 'I';
                }
                $codigoDactilar = implode('', $dactilarSplit);
                break;
            }
        }
        foreach ($lines as $key => $text) {

            $description = $text;
            if (str_contains($description, 'NUI.')) {
                $identification = str_replace('NUI.', '', $description);
            }
            if (str_contains($prev, 'FECHA DE NACIMIENTO')) {
                $nacimiento = $description;

            }
            if (str_contains($prev, 'SEXO')) {
                $sexo = $description;

            }
            if (str_contains($text, 'APELLIDOS')) {
                if (!str_contains($lines[$key + 1], 'CIUDADANIA')) {
                    $apellidoA = $lines[$key + 1];

                    $apellidoB = $lines[$key + 2];
                } else {
                    $apellidoA = $lines[$key + 2];

                    $apellidoB = $lines[$key + 3];
                }


            }
            if (str_contains($text, 'NOMBRES')) {

                $nombres = $lines[$key + 1];

            }
            if (str_contains($text, 'LUGAR DE NACIMIENTO')) {


                $lugarNacimiento = $lines[$key + 1];
                $lugarNacimientoB = $lines[$key + 2];

            }

            $prev = $description;

        }
        //$text = implode("\n", $dataT);
        $data = [
            "Cédula" => $identification,
            "Fecha de nacimiento" => $nacimiento,
            "Sexo" => $sexo,
            "Apellido 1" => $apellidoA,
            "Apellido 2" => $apellidoB,
            "Nombres" => $nombres,
            "Lugar Nacimiento" => $lugarNacimiento,
            "Direccion" => $lugarNacimientoB,
            "Codigo Dactilar" => $codigoDactilar,
        ];
        echo json_encode($data);


    }

    public
    function checkRequirementab()
    {
        $form = $this->request->validate([
            'identification_front' => 'file|required|mimes:png,jpeg,jpg',
            'identification_back' => 'file|required|mimes:png,jpeg,jpg',
            'selfie' => 'file|required|mimes:png,jpeg,jpg',
        ]);

        $identificationFront = $this->request->file('identification_front')->getRealPath();
        $identificationBack = $this->request->file('identification_back')->getRealPath();
        $selfie = $this->request->file('selfie')->getRealPath();


        $content = file_get_contents($identificationFront);
        $textractClient = new TextractClient([
            'version' => 'latest',
            'region' => config('services.aws.region'),
            'credentials' => [
                'key' => config('services.aws.credentials.key'),
                'secret' => config('services.aws.credentials.secret'),
            ],
        ]);
        $result = $textractClient->analyzeDocument(
            [
                "AdaptersConfig" => [
                    "Adapters" => [
                        [
                            "AdapterId" => "133f13f09f6f",
                            "Pages" => ["1"],
                            "Version" => "1"
                        ]
                    ]
                ],
                "Document" => [
                    "Bytes" => $content,

                ],
                "FeatureTypes" => ["QUERIES"],
                "QueriesConfig" => [
                    "Queries" => [
                        [
                            "Alias" => "nombres",
                            "Pages" => ["1"],
                            "Text" => "nombres"
                        ],
                        [
                            "Alias" => "primer apellido",
                            "Pages" => ["1"],
                            "Text" => "primer apellido"
                        ],
                        [
                            "Alias" => "segundo apellido",
                            "Pages" => ["1"],
                            "Text" => "segundo apellido"
                        ],
                        [
                            "Alias" => "fecha de nacimiento",
                            "Pages" => ["1"],
                            "Text" => "fecha de nacimiento"
                        ],
                        [
                            "Alias" => "provincia",
                            "Pages" => ["1"],
                            "Text" => "provincia"
                        ]
                    ]
                ]
            ]
        );
        $blocks = $result['Blocks'];
        $contenidoOrdenado = "";
        foreach ($blocks as $block) {
            // Verifica si el bloque es una palabra o una línea de texto
            if ($block['BlockType'] === 'WORD') {
                $contenidoOrdenado .= $block['Text'] . ' ';
            } elseif ($block['BlockType'] === 'LINE') {
                $contenidoOrdenado .= $block['Text'] . "\n";
            }
        }
        echo $contenidoOrdenado;
        var_dump($result);
        // $result = $textractClient->detectDocumentText()
    }
}
