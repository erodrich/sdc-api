<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    //
    public function deliverAd($id){
        $beacon = \App\Beacon::where('hw_id', '=', $id)->first();
        if($beacon){
            //$ad = \App\Ad::find(rand(1,10));
            $ad = $beacon->campaign()->first()->ads()->first();
            return new \App\Http\Resources\AdResource($ad);
        }
    }
}
