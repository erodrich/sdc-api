<?php

namespace App\Http\Controllers;

use App\Sdc\Business\AppBusiness;
use App\Sdc\Repositories\AdRepositoryImpl;
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
        //$var1 = Input::get("client_id");
        $response = $this->appBusiness->getOverview($client_id);
        if($response){
            CustomLog::debug($this->class, $metodo, json_encode($response));
        } else {
            $error = new ErrorNotFoundResponse();
            return new ErrorResource($error);
        }
    }

    public function search(){
        $metodo = 'overview';
        //$var1 = Input::get("client_id");
        $response = $this->appBusiness->search();
        if($response){
            CustomLog::debug($this->class, $metodo, json_encode($response));
        } else {
            $error = new ErrorNotFoundResponse();
            return new ErrorResource($error);
        }
    }
}
