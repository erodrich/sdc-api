<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientsResource;
use Illuminate\Support\Facades\Validator;
use App\Sdc\Repositories\ClientRepositoryInterface;
use App\Sdc\Utilities\CustomLog;
use App\Sdc\Utilities\Constants;

class ClientController extends Controller
{

    protected $class = "ClientController";

    public function __construct(ClientRepositoryInterface $clientDao){
        $this->clientDao = $clientDao;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metodo = "index";

        CustomLog::debug($this->class, $metodo, json_encode($this->clientDao->retrieveAll()));
        return new ClientsResource($this->clientDao->retrieveAll());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $metodo = "store";

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ruc' => 'required',
            'description' => 'required'
        ]);
         
        if ($validator->fails()) {
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            return response()->json(Constants::RESPONSE_BAD_REQUEST, Constants::CODE_BAD_REQUEST);
        } else {
            $client = $this->clientDao->save($request->all());
            
            CustomLog::debug($this->class, $metodo, json_encode($client));
            return new ClientResource($client);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $metodo = "show";
        
        $client = $this->clientDao->retrieveById($id);
        CustomLog::debug($this->class, $metodo, json_encode($client));
        if($client){
            return new ClientResource($client);
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
            'name' => 'required',
            'ruc' => 'required',
            'description' => 'required'
        ]);
        
        if ($validator->fails()) {
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            return response()->json(Constants::RESPONSE_BAD_REQUEST, Constants::CODE_BAD_REQUEST);
        } else {
            $client = $this->clientDao->update($request->all(), $id);
            if($client){
                return new ClientResource($client);
            } else {
                return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
            }
            
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $metodo = "destroy";
        
        if($this->clientDao->delete($id)){
            CustomLog::debug($this->class, $metodo, "Se elimino el cliente: ".$id);
            return response()->json(Constants::RESPONSE_DELETE, Constants::CODE_DELETE);
        } else {
            CustomLog::debug($this->class, $metodo, "No existe el cliente: ".$id);
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }
		
    }
}
