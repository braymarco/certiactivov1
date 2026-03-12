<?php

namespace App\Models;

use App\Enums\DocumentTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentUpdate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function previusDocument()
    {
        return $this->belongsTo(Document::class, 'previus_document_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function tipoStr()
    {
        $strs = DocumentTypes::str();
        return $strs[$this->type];
    }

    public function linkUpdate()
    {
        return route('document.view', [
            'token' => $this->token
        ]);
    }
}
