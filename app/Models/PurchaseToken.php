<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string email
 * @property string plan_code
 */
class PurchaseToken extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function plan()
    {
        return $this->belongsTo(Plan::class );
    }
    public function linkCliente(){
        return route('purchase-token.type', [
            'purchaseToken' => $this->token
        ]);
    }
    public function celularGlobal()
    {
        return '593' . substr($this->phone, 1);
    }
}
