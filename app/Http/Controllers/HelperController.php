<?php

namespace App\Http\Controllers;

use App\Ai\Agents\OCR;
use App\Ai\Agents\OCRExternal;
use App\Enums\DocumentTypes;
use App\Facades\UanatacaFacade;
use App\Helpers\EmailHelper;
use App\Models\SignatureRequest;
use App\Services\Dashscope;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Ai\Files\Document;

class HelperController extends Controller
{
    public function test()
    {
        $sRequest = SignatureRequest::find(1);
        $document = $sRequest->documents->where('type', DocumentTypes::$CEDULA_POSTERIOR)->first();
        $b64 = base64_encode($document->content());
        $message = 'Cuál es el código dactilar?';
        $res = Dashscope::ocr($b64,$message);
        //guzzle
        die($res);
    }
}
