<?php

namespace App\Facades;

use App\Models\History;

class HistoryFacade
{
    public static function create($description, $solicitudId, $level = 1)
    {

        $userId = (\Auth::check()) ? auth()->user()->id : null;
        History::create([
            'description' => $description,
            'signature_request_id' => $solicitudId,
            'nivel_vista' => $level,
            'user_id' => $userId
        ]);
    }

}
