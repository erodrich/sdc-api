<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    //
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }

    public function beacon()
    {
        return $this->belongsTo('App\Beacon');
    }


}
