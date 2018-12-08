<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\GenericResource;
use App\Sdc\Business\BeaconBusiness;
use App\Sdc\Repositories\BeaconRepositoryInterface;
use App\Sdc\Responses\DeleteResponse;
use App\Sdc\Responses\ErrorNotFoundResponse;
use App\Sdc\Responses\ErrorServerResponse;
use App\Sdc\Responses\ErrorValidationResponse;
use Illuminate\Http\Request;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;
use App\Sdc\Utilities\CustomLog;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;


class BeaconController extends Controller
{
    protected $class = "BeaconController";
    protected $beaconBusiness;

    public function __construct(BeaconRepositoryInterface $beaconDao){
        $this->beaconBusiness = new BeaconBusiness($beaconDao);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index()
    {
        //
        $metodo = "index";
        $beacons = $this->beaconBusiness->retrieveAll();
        CustomLog::debug($this->class, $metodo, json_encode($beacons));
		return new BeaconsResource($beacons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResource
     */
    public function store(Request $request)
    {
        $metodo = "store";

        $validator = Validator::make($request->all(), [
            'hw_id' => 'required',
            'alias' => 'required',
        ]);

        if($validator->fails()){
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            $errorValidation = new ErrorValidationResponse();
            return response()->json(new ErrorResource($errorValidation), $errorValidation->status);
        }
        $beacon = $this->beaconBusiness->save($request->all());
        if($beacon){
            CustomLog::debug($this->class, $metodo, json_encode($beacon));
            return new BeaconResource($beacon);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($beacon));
            $errorServer = new ErrorServerResponse();
            return response()->json(new ErrorResource($errorServer), $errorServer->status);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResource
     */
    public function show(int $id)
    {
        //
        $metodo = "show";

        $beacon = $this->beaconBusiness->retrieveById($id);
        CustomLog::debug($this->class, $metodo, json_encode($beacon));
        if($beacon){
            return new BeaconResource($beacon);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResource
     */
    public function update(Request $request, $id)
    {
        //
        $metodo = "update";
        $validator = Validator::make($request->all(), [
            'hw_id' => 'required',
            'alias' => 'required',
        ]);

        if($validator->fails()){
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            $errorValidation = new ErrorValidationResponse();
            return response()->json(new ErrorResource($errorValidation), $errorValidation->status);
        } else {
            $beacon = $this->beaconBusiness->update($request->all(), $id);
            if($beacon){
                return new BeaconResource($beacon);
            } else {
                $errorNotFound = new ErrorNotFoundResponse();
                return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
            }
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResource
     */
    public function destroy(int $id)
    {
        $metodo = "destroy";

        if($this->beaconBusiness->delete($id)){
            CustomLog::debug($this->class, $metodo, "Se elimino el beacon: ".$id);
            $deleteResponse = new DeleteResponse();
            return response()->json(new GenericResource($deleteResponse), $deleteResponse->status);
        } else {
            CustomLog::debug($this->class, $metodo, "No existe el beacon: ".$id);
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }
    }
}
