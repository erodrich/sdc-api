<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    //
    public function deliverAd($id){
        $beacon = \App\Beacon::where('hw_id', '=', $id)->first();
        if($beacon){
            try{
                $ad = $beacon->campaign()->first()->ads()->first();
                return new \App\Http\Resources\AdResource($ad);
            }
            catch (Exception $ex){
                return response()->json('El Beacon no tiene campaña o anuncios asignados', 400);
            }
            
        }
    }
}
