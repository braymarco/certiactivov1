<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInfo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function additionalInfoable()
    {
        return $this->morphTo();
    }
}
