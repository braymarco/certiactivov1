<?php

namespace App\Http\Controllers\Api;

use App\Facades\ConfigFacade;
use App\Helpers\EmailHelper;
use App\Http\Controllers\Controller;
use App\Models\AdditionalInfo;
use App\Models\ApiResponse;
use App\Models\SignatureRequest;
use App\Models\WebhookMessage;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class WebhookController extends Controller
{
    //
    public function uanataca(Request $request)
    {
        $token = $request->bearerToken();
        if ($token !== ConfigFacade::get('WEBHOOK_TOKEN_UANATACA')) {
            return ApiResponse::error("Token inválido", ResponseAlias::HTTP_UNAUTHORIZED);
        }
        WebhookMessage::create([
            'from' => 'UANATACA',
            'content' => file_get_contents('php://input'),
        ]);
        return ApiResponse::success('success');

    }

    public function uanatacaDocumentation(Request $request)
    {
        $token = $request->bearerToken();
        if ($token !== ConfigFacade::get('WEBHOOK_TOKEN_UANATACA')) {
            return ApiResponse::error("Token inválido", ResponseAlias::HTTP_UNAUTHORIZED);
        }
        $content = file_get_contents('php://input');
        WebhookMessage::create([
            'from' => 'UANATACA_DOCUMENTATION',
            'content' => $content,
        ]);
        try{
            $textEmail = EmailHelper::extractPlainText($content);
            $textEmail=EmailHelper::extractEmailBody($textEmail);
            if (preg_match('/con identificación\s+\*?(\d+)\*?/i', $textEmail, $matches)) {
                $identification = trim($matches[1]);

                $signatureRequest = SignatureRequest::where('nro_documento', $identification)
                    ->orderBy('id', 'DESC')
                    ->first();
                if ($signatureRequest !== null) {
                    AdditionalInfo::create([
                        'content' => $textEmail,
                        'additional_infoable_id' => $signatureRequest->id,
                        'additional_infoable_type' => SignatureRequest::class
                    ]);
                }
            }
        }catch (\Exception $e){
            Log::error('Error processing UANATACA documentation webhook: ' . $e->getMessage());
        }



        return ApiResponse::success('success');

    }
}
