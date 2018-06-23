<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    //
    public function beacons()
    {
        return $this->hasMany('App\Beacon');
    }
}
