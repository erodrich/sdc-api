<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = ['name','ruc','description'];
	//
	public function users()
	{
		return $this->hasMany('App\User');
	}

	//
	public function campaigns()
	{
		return $this->hasMany('App\Campaign');
	}

	public function beacons()
	{
		return $this->hasMany('App\Beacon');
	}

}
