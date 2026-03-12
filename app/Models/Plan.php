<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property integer order
 * @property integer code
 * @property integer duration
 * @property integer duration_unit
 */
class Plan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function __toString()
    {
        return $this->name;
    }
}
