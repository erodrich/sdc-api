<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sdc\Utilities\CustomLog;
use Exception;

class StatisticController extends Controller
{
    private $class = "StatisticController";

    public function store(Request $request){
        $metodo = "store";
        try{
            $stat = new \App\Statistic;
            $stat->user_id = $request->user_id;
            $stat->campaign_id = $request->campaign_id;
            $stat->ad_id = $request->ad_id;
            $stat->client_id = $request->client_id;
            $stat->action = strtolower($request->action);
            $stat->fecha_hora = $request->fecha_hora;
            $stat->save();
            return response()->json('Dato agregado', 200);
        } catch (Exception $ex) {
            CustomLog::error($this->class, $metodo, $ex->getMessage());
        }
    }

    public function index(){
        return response()->json(\App\Statistic::all());
    }
}
