<?php

namespace App\Models;

use App\Enums\DocumentStatus;
use App\Enums\SignatureRequestStatus;
use App\Enums\SignatureRequestTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function estadoStr()
    {
        return SignatureRequestStatus::$STR[$this->estado];
    }

    public function estadoLocalStr()
    {
        return SignatureRequestStatus::$STR_LOCAL[$this->estado];
    }

    public function documents()
    {

        return $this->hasMany(Document::class);
    }

    public function documentUpdates()
    {

        return $this->hasManyThrough(DocumentUpdate::class,
            Document::class,
            'signature_request_id',
            'previus_document_id',
        );
    }

    public function linkCliente()
    {
        return route('solicitud_cliente.view', [
            'token' => $this->token
        ]);
    }

    public function shortName()
    {
        $name = explode(' ', $this->nombres);
        $firstName = $name[0];
        return $firstName . " " . $this->apellido1;
    }

    public function fullName()
    {
        $fullName = $this->nombres . " " . $this->apellido1 . " " . $this->apellido2;
        return trim($fullName);
    }

    public function apellidos()
    {
        return trim("$this->apellido1 $this->apellido2");
    }

    public function classColor()
    {
        switch ($this->estado) {
            case SignatureRequestStatus::$CREATED:
                return 'info';
            case SignatureRequestStatus::$ISSUED:
                return 'success';
            case SignatureRequestStatus::$DOCUMENT_CHANGE:
                return 'warning';
            default:
                return 'secondary';
        }
    }

    public function requisitoActivo($tipo)
    {
        return $this->requisitosActivos()[$tipo] ?? null;
    }

    public function requisitosActivos(): array
    {
        return Document::where('signature_request_id', $this->id)
            ->whereIn('status', [
                DocumentStatus::$CREATED,
                DocumentStatus::$APPROVED,
                DocumentStatus::$NEED_UPDATE,
            ])
            ->get()
            ->keyBy('type')
            ->all();
    }

    public function celularGlobal()
    {
        return '593' . substr($this->celular, 1);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function canton()
    {
        return $this->belongsTo(Canton::class);
    }

    public function uanatacaRequestFirst()
    {
        if (count($this->uanatacaRequest) == 0)
            return null;
        return $this->uanatacaRequest[count($this->uanatacaRequest) - 1];
    }

    public function uanatacaRequest()
    {
        return $this->hasMany(UanatacaRequest::class, 'signature_request_id', 'id');


    }

    public function tipoStr()
    {
        return SignatureRequestTypes::$STR[$this->tipo];
    }

    public function additionalInfo()
    {
        return $this->morphMany(AdditionalInfo::class, 'additional_infoable');
    }
}
