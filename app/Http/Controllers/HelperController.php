<?php

namespace App\Http\Controllers;

use App\Ai\Agents\OCR;
use App\Enums\DocumentTypes;
use App\Facades\UanatacaFacade;
use App\Helpers\EmailHelper;
use App\Models\SignatureRequest;
use App\Services\Dashscope;
use App\Services\OCRService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Ai\Files\Document;

class HelperController extends Controller
{
    public function test()
    {
//        $sRequest    = SignatureRequest::find(1);
//        $documentFro = $sRequest->documents->where('type', DocumentTypes::$CEDULA_FRONTAL)->first();
//        $documentPos = $sRequest->documents->where('type', DocumentTypes::$CEDULA_POSTERIOR)->first();
//
//        $result = Dashscope::ocr(
//            base64_encode($documentFro->content()),
//            base64_encode($documentPos->content())
//        );
//
//        return response()->json($result);

        $sRequest = SignatureRequest::find(2);

        $sRequest2 = SignatureRequest::find(1);


        $result = OCRService::verifySignatureRequest($sRequest);

        $result2 = OCRService::verifySignatureRequest($sRequest2);

        return response()->json([
            'verified' => $result,
            'verified2' => $result2,
        ]);





    }
}
