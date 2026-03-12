<?php

namespace App\Http\Controllers\Api;

use App\Enums\SignatureRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\ApiResponse;
use App\Models\SignatureRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ReportController extends Controller
{
    public static function created(Request $request)
    {
        $token = $request->header('token');
        if ($token == null)
            return ApiResponse::error("Token Necesario", ResponseAlias::HTTP_UNAUTHORIZED);

        $user = User::where('api_token', $token)->first();

        if ($user === null)
            return ApiResponse::error("Token Inválido $token", ResponseAlias::HTTP_UNAUTHORIZED);
        return ApiResponse::success([
            'created' => SignatureRequest::where('estado', SignatureRequestStatus::$CREATED)->count()
        ]);
    }
}
