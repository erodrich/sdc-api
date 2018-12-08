<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Http\Resources\GenericResource;
use App\Sdc\Business\ClientBusiness;
use App\Sdc\Responses\DeleteResponse;
use App\Sdc\Responses\ErrorNotFoundResponse;
use App\Sdc\Responses\ErrorServerResponse;
use App\Sdc\Responses\ErrorValidationResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientsResource;
use Illuminate\Support\Facades\Validator;
use App\Sdc\Repositories\ClientRepositoryInterface;
use App\Sdc\Utilities\CustomLog;

class ClientController extends Controller
{

    protected $class = "ClientController";
    private $clientBusiness;

    public function __construct(ClientRepositoryInterface $clientDao){
        $this->clientBusiness = new ClientBusiness($clientDao);

    }

    /**
     * Display a listing of the resource.
     *
     * @return ClientsResource
     */
    public function index()
    {
        $metodo = "index";
        $clients = $this->clientBusiness->retrieveAll();

        CustomLog::debug($this->class, $metodo, json_encode($clients));
        return new ClientsResource($clients);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResource
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
            $errorValidation = new ErrorValidationResponse();
            return response()->json(new ErrorResource($errorValidation), $errorValidation->status);

        }
        $client = $this->clientBusiness->save($request->all());
        if($client){
            CustomLog::debug($this->class, $metodo, json_encode($client));
            return new ClientResource($client);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($client));
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
    public function show($id)
    {
        $metodo = "show";

        $client = $this->clientBusiness->retrieveById($id);
        CustomLog::debug($this->class, $metodo, json_encode($client));
        if($client){
            return new ClientResource($client);
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
            'name' => 'required',
            'ruc' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            $errorValidation = new ErrorValidationResponse();
            return response()->json(new ErrorResource($errorValidation), $errorValidation->status);
        } else {
            $client = $this->clientBusiness->update($request->all(), $id);
            if($client){
                return new ClientResource($client);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $metodo = "destroy";

        if($this->clientBusiness->delete($id)){
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
