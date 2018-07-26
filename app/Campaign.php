<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
	//
	public function ads()
	{
		return $this->hasMany('App\Ad');
	}
}
