<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overview extends Model
{
    protected $attributes = [
        'client_id' => 0,
        'total_campaigns' => 0,
        'active_campaigns' => 0,
        'total_ads' => 0,
        'viewed_ads' => 0,
        'emitted_reports' => 0,
    ];
}
