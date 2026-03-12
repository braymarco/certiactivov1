<?php

namespace App\Models;

use App\Enums\DocumentStatus;
use App\Enums\DocumentTypes;
use App\Enums\SignatureRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function content(): ?string
    {
        $disk = \Storage::disk('requisitos');
        return $disk->get($this->path);
    }

    public function signatureRequest()
    {
        return $this->belongsTo(SignatureRequest::class);
    }

    public function documentUpdate()
    {
        return $this->hasOne(DocumentUpdate::class, 'previus_document_id', 'id');
    }

    public function tipoStr()
    {
        $strs = DocumentTypes::str();
        return $strs[$this->type];
    }

    public function statusStr()
    {
        return DocumentStatus::$STR[$this->status];
    }

    public function classColor()
    {
        switch ($this->status) {
            case DocumentStatus::$CREATED:
                return 'info';
            case DocumentStatus::$APPROVED:
                return 'success';
            case DocumentStatus::$NEED_UPDATE:
                return 'warning';
            default:
                return 'secondary';
        }
    }

}
