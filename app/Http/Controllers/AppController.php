<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    //
    public function deliverAd($id){
        $beacon = \App\Beacon::where('hw_id', '=', $id)->get();
        if($beacon){
            $ad = \App\Ad::find(rand(1,10));
            return new \App\Http\Resources\AdResource($ad);
        }
    }
}
