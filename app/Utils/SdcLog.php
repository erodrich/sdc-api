<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;

class SDCLog
{

    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function debug($method, $message){
        Log::debug($this->class.' :: '.$method.' :: '. $message);
    }
}