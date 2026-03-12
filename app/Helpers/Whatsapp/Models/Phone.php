<?php

namespace App\Helpers\Whatsapp\Models;

class Phone
{
    public $number;
    public $status;
    public $token;
    public function __construct($obj)
    {
        foreach ($obj as $key=>$value)
            $this->$key=$value;
    }

}
