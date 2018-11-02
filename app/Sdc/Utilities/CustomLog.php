<?php

namespace App\Sdc\Utilities;

use Illuminate\Support\Facades\Log;

class CustomLog
{

    public function __construct(string $class)
    {
        $this->class = $class;
    }

    public static function debug($class, $method, $message){
        Log::debug($class.' :: '.$method.' :: '. $message);
    }

    public static function info($class, $method, $message){
        Log::info($class.' :: '.$method.' :: '. $message);
    }

    public static function error($class, $method, $message){
        Log::error($class.' :: '.$method.' :: '. $message);
    }
}