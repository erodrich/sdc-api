<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticController extends Controller
{
    //
    public function store(Request $request){
        try{
            $stat = new \App\Statistic;
            $stat->user_id = $request->user_id;
            $stat->campaign_id = $request->campaign_id;
            $stat->ad_id = $request->ad_id;
            $stat->client_id = $request->client_id;
            $stat->action = strtolower($request->action);
            $stat->fecha_hora = $request->fecha_hora;
            $stat->save();
            return response()->json('Dato agregado', 400); 
        } catch (Exception $ex) {
            $this->log->debug($ex);
        }
    }

    public function index(){
        return response()->json(\App\Statistic::all());
    }
}
