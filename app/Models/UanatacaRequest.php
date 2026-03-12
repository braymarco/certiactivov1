<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UanatacaRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function signatureRequest()
    {
        return $this->belongsTo(SignatureRequest::class);
    }
}
