<?php

namespace App\Helpers\Whatsapp\Models;

class MessageResponse
{

    public function __construct($obj)
    {
        foreach ($obj as $key=>$value)
            $this->$key=$value;
    }

}
