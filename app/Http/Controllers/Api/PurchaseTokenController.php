<?php

namespace App\Http\Controllers\Api;

use App\Facades\ConfigFacade;
use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Mail\InicioSolicitudMail;
use App\Mail\PurchaseTokenMail;
use App\Models\ApiResponse;
use App\Models\Plan;
use App\Models\PurchaseToken;
use App\Models\SignatureRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PurchaseTokenController extends Controller
{

    public function generate()
    {
        $token = $this->request->header('token');
        if ($token == null)
            return ApiResponse::error("Token Necesario", ResponseAlias::HTTP_UNAUTHORIZED);

        $user = User::where('api_token', $token)->first();

        if ($user === null)
            return ApiResponse::error("Token Inválido $token", ResponseAlias::HTTP_UNAUTHORIZED);
        $form = $this->request->validate([
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'tx_id' => 'required|max:36',
            'plan' => 'required',
        ]);
        $planId = $form['plan'];
        $purchaseToken = PurchaseToken::
        where('tx_id', $form['tx_id'])
            ->where('user_id', $user->id)
            ->first();
        if ($purchaseToken !== null)
            return ApiResponse::error("TX ID Existente", ResponseAlias::HTTP_CONFLICT);
        $plan = Plan::where('id', $planId)->where('status', true)->first();
        if ($plan == null) {
            return ApiResponse::error("Plan no encontradio", ResponseAlias::HTTP_NOT_FOUND);
        }
        $purchaseToken = PurchaseToken::create([
            'email' => $form['email'],
            'phone' => $form['phone'],
            'tx_id' => $form['tx_id'],
            'plan_id' => $plan->id,
            'token' => Str::random('40'),
            'user_id' => $user->id
        ]);
        $mensaje = "¡Hola ☺️! Gracias por elegirnos."
            . "\n\nEstoy aquí para ayudarte con tu firma electrónica. Completa tus datos y la documentación en el siguiente enlace:\n\n"
            . $purchaseToken->linkCliente();
        Notify::whatapi('certiactivo', $purchaseToken->celularGlobal(), $mensaje);
        try {
            Mail::to($purchaseToken->email)
                ->queue(new PurchaseTokenMail($purchaseToken));
        } catch (\Exception $e) {

        }
        return ApiResponse::success([
            "link" => $purchaseToken->linkCliente()
        ], "Enlace generado");
    }

    public function check()
    {
        $token = request()->header('token');

        if ($token == null)
            return ApiResponse::error("Token Necesario", ResponseAlias::HTTP_UNAUTHORIZED);
        $user = User::where('api_token', $token)->first();

        if ($user === null)
            return ApiResponse::error("Token Inválido", ResponseAlias::HTTP_UNAUTHORIZED);

        $this->request->validate([
            'tx_id' => 'required'
        ]);
        $purchaseToken = PurchaseToken::where('tx_id', $this->request->tx_id)->first();
        if ($purchaseToken === null)
            return ApiResponse::error("Registro no existe", ResponseAlias::HTTP_NOT_FOUND);
        return ApiResponse::success([
            "link" => $purchaseToken->linkCliente()
        ]);
    }
}
