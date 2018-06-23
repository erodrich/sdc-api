<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{
    //
    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }
}
