<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
    use HasFactory;

    protected $table = 'cantones';
    protected $guarded = ['id'];
    protected $hidden = ['provincia_id', 'created_at', 'updated_at'];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
}
