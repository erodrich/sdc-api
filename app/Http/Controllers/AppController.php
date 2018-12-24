<?php

namespace App\Http\Controllers;

use App\Sdc\Business\AppBusiness;
use App\Sdc\Repositories\AdRepositoryImpl;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ErrorResource;
use App\Sdc\Responses\ErrorNotFoundResponse;
use App\Sdc\Utilities\CustomLog;

class AppController extends Controller
{
    protected $class = 'AppController';

    public function deliverAd($id){
        $metodo = 'deliverAd';
        $appBusiness = new AppBusiness();
        $response = $appBusiness->deliverAd($id);
        if($response){
            CustomLog::debug($this->class, $metodo, json_encode($response));
            return new JsonResource($response);
        } else {
            $errorServer = new ErrorNotFoundResponse();
            return new ErrorResource($errorServer);
        }
        
    }
}
