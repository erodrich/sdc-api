<?php

namespace App\Http\Controllers;

use App\Http\Resources\InteractionsResource;
use App\Http\Resources\OverviewResource;
use App\Sdc\Business\AppBusiness;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ErrorResource;
use App\Sdc\Responses\ErrorNotFoundResponse;
use App\Sdc\Utilities\CustomLog;
use Illuminate\Support\Facades\Input;

class AppController extends Controller
{
    protected $class = 'AppController';
    protected $appBusiness;

    public function __construct(AppBusiness $appBusiness)
    {
        $this->appBusiness = $appBusiness;
    }

    public function deliverAd($id){
        $metodo = 'deliverAd';
        $response = $this->appBusiness->deliverAd($id);
        if($response){
            CustomLog::debug($this->class, $metodo, json_encode($response));
            return new JsonResource($response);
        } else {
            $error = new ErrorNotFoundResponse();
            return new ErrorResource($error);
        }

    }

    public function overview($client_id){
        $metodo = 'overview';

        $response = $this->appBusiness->getOverview($client_id);
        if($response){
            CustomLog::debug($this->class, $metodo, json_encode($response));
            return new OverviewResource($response);
        } else {
            $error = new ErrorNotFoundResponse();
            return new ErrorResource($error);
        }
    }

    public function search($client_id){
        $metodo = 'search';
        $params = Input::all();

        $response = $this->appBusiness->search($client_id, $params);
        if($response){
            CustomLog::debug($this->class, $metodo, json_encode($response));
            return new InteractionsResource($response);
        } else {
            $error = new ErrorNotFoundResponse();
            return new ErrorResource($error);
        }

    }
}
