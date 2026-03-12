<?php

namespace App\Http\Controllers;

use App\Enums\DocumentStatus;
use App\Enums\FormatoFirma;
use App\Facades\HistoryFacade;
use App\Models\Document;
use App\Models\DocumentUpdate;
use App\Models\History;
use App\Models\SignatureRequest;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function solicitud($token)
    {
        $solicitud = SignatureRequest::where('token', $token)->first();
        if ($solicitud === null)
            return "Solicitud Inválida";
        HistoryFacade::create(
            "Revisión de solicitud por parte del cliente mediante link.",
            $solicitud->id
        );
        $formatosFirma = FormatoFirma::class;
        $documentosActivos = Document::where('signature_request_id', $solicitud->id)
            ->whereIn('status', [
                DocumentStatus::$CREATED,
                DocumentStatus::$NEED_UPDATE,
                DocumentStatus::$APPROVED,
            ])->get();
        return view('clientes.solicitud', [
            'solicitud' => $solicitud,
            'formatosFirma' => $formatosFirma,
            'documentosActivos' => $documentosActivos,
        ]);
    }
}
