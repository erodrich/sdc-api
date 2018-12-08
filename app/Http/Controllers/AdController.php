<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\GenericResource;
use App\Sdc\Business\AdBusiness;
use App\Sdc\Responses\DeleteResponse;
use App\Sdc\Responses\ErrorNotFoundResponse;
use App\Sdc\Responses\ErrorServerResponse;
use App\Sdc\Responses\ErrorValidationResponse;
use App\Sdc\Utilities\CustomLog;
use Illuminate\Http\Request;
use App\Http\Resources\AdResource;
use Illuminate\Support\Facades\Validator;
use App\Sdc\Repositories\AdRepositoryInterface;

/**
 * @property AdRepositoryInterface adDao
 */
class AdController extends Controller
{
    protected $class = "AdController";
    protected $adBusiness;

    public function __construct(AdRepositoryInterface $adDao)
    {
        $this->adBusiness = new AdBusiness($adDao);
    }

    public function index()
    {
        $metodo = "index";

        $ads = $this->adBusiness->retrieveAll();
        CustomLog::debug($this->class, $metodo, json_encode($ads));
        return AdResource::collection($ads);

    }

    public function store(Request $request)
    {
        $metodo = 'store';

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: " . json_encode($request->all()));
            $errorValidation = new ErrorValidationResponse();
            return response()->json(new ErrorResource($errorValidation), $errorValidation->status);
        }
        $ad = $this->adBusiness->save($request->all());
        if ($ad) {
            CustomLog::debug($this->class, $metodo, json_encode($ad));
            return new AdResource($ad);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($ad));
            $errorServer = new ErrorServerResponse();
            return response()->json(new ErrorResource($errorServer), $errorServer->status);
        }

    }


    public function show(int $ad)
    {
        //
        $metodo = "show";

        $ad = $this->adBusiness->retrieveById($ad);
        CustomLog::debug($this->class, $metodo, json_encode($ad));
        if ($ad) {
            return new AdResource($ad);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }

    }


    public function update(Request $request, $id)
    {
        $metodo = 'store';

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            $errorValidation = new ErrorValidationResponse();
            return response()->json(new ErrorResource($errorValidation), $errorValidation->status);
        } else {
            $ad = $this->adBusiness->update($request->all(), $id);
            if($ad){
                return new AdResource($ad);
            } else {
                $errorNotFound = new ErrorNotFoundResponse();
                return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
            }

        }

    }


    public function destroy($id)
    {
        $metodo = "destroy";

        if($this->adBusiness->delete($id)){
            CustomLog::debug($this->class, $metodo, "Se elimino el cliente: ".$id);
            $deleteResponse = new DeleteResponse();
            return response()->json(new GenericResource($deleteResponse), $deleteResponse->status);
        } else {
            CustomLog::debug($this->class, $metodo, "No existe el cliente: ".$id);
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }

    }
}
