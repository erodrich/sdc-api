<?php

namespace App\Http\Controllers;

use App\Sdc\Repositories\BeaconRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;
use App\Sdc\Utilities\CustomLog;
use App\Sdc\Utilities\Constants;
use Illuminate\Support\Facades\Validator;


class BeaconController extends Controller
{
    protected $class = "BeaconController";
    protected $beaconDao;

    public function __construct(BeaconRepositoryInterface $beaconDao){
        $this->beaconDao = $beaconDao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $metodo = "index";
        CustomLog::debug($this->class, $metodo, json_encode($this->beaconDao->retrieveAll()));
		return new BeaconsResource($this->beaconDao->retrieveAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $metodo = "store";

        $validator = Validator::make($request->all(), [
            'hw_id' => 'required',
            'alias' => 'required',
            'ubicacion' => 'required'
        ]);

        if($validator->fails()){
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            return response()->json(Constants::RESPONSE_BAD_REQUEST, Constants::CODE_BAD_REQUEST);
        }
        $beacon = $this->beaconDao->save($request->all());
        if($beacon){
            CustomLog::debug($this->class, $metodo, json_encode($beacon));
            return new BeaconResource($beacon);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($beacon));
            return response()->json(Constants::RESPONSE_SERVER_ERROR, Constants::CODE_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
        $metodo = "show";

        $beacon = $this->beaconDao->retrieveById($id);
        CustomLog::debug($this->class, $metodo, json_encode($beacon));
        if($beacon){
            return new BeaconResource($beacon);
        } else {
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $metodo = "update";
        $validator = Validator::make($request->all(), [
            'hw_id' => 'required',
            'alias' => 'required',
            'ubicacion' => 'required'
        ]);

        if($validator->fails()){
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            return response()->json(Constants::RESPONSE_BAD_REQUEST, Constants::CODE_BAD_REQUEST);
        }

        $beacon = $this->beaconDao->update($request->all(), $id);
        if($beacon){
            CustomLog::debug($this->class, $metodo, json_encode($beacon));
            return new BeaconResource($beacon);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($beacon));
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $metodo = "destroy";

        if($this->beaconDao->delete($id)){
            CustomLog::debug($this->class, $metodo, "Se elimino el beacon: ".$id);
            return response()->json(Constants::RESPONSE_DELETE, Constants::CODE_DELETE);
        } else {
            CustomLog::debug($this->class, $metodo, "No existe el beacon: ".$id);
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }
    }
}
