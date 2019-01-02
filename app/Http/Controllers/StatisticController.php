<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Sdc\Business\InteractionBusiness;
use App\Sdc\Repositories\InteractionRepositoryInterface;
use App\Sdc\Responses\ErrorServerResponse;
use Illuminate\Http\Request;
use App\Sdc\Utilities\CustomLog;
use Exception;

class StatisticController extends Controller
{
    private $class = "StatisticController";
    protected $interactionBusiness;

    public function __construct(InteractionRepositoryInterface $interactionDao)
    {
        $this->interactionBusiness = new InteractionBusiness($interactionDao);
    }

    public function store(Request $request){
        $metodo = "store";

        $interaction = $this->interactionBusiness->save($request->all());
        if($interaction){
            CustomLog::debug($this->class, $metodo, json_encode($interaction));
            //return new ClientResource($interaction);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($interaction));
            $errorServer = new ErrorServerResponse();
            return response()->json(new ErrorResource($errorServer), $errorServer->status);
        }
    }

    public function index(){
        return response()->json(\App\Statistic::all());
    }
}
