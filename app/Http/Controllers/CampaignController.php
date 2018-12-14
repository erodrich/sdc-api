<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampaignResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\GenericResource;
use App\Sdc\Business\CampaignBusiness;
use App\Sdc\Responses\DeleteResponse;
use App\Sdc\Responses\ErrorNotFoundResponse;
use App\Sdc\Responses\ErrorServerResponse;
use App\Sdc\Responses\ErrorValidationResponse;
use App\Sdc\Utilities\Constants;
use App\Sdc\Utilities\CustomLog;
use Illuminate\Http\Request;
use App\Sdc\Repositories\CampaignRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    protected $class = "CampaignController";
    private $campaignBusiness;

    public function __construct(CampaignRepositoryInterface $campaignDao)
    {
        $this->campaignBusiness = new CampaignBusiness($campaignDao);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //
        $metodo = "index";

        $campaigns = $this->campaignBusiness->retrieveAll();
        CustomLog::debug($this->class, $metodo, json_encode($campaigns));
        return CampaignResource::collection($campaigns);

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
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'active' => 'required',
            'client_id' => 'required'
        ]);

        if ($validator->fails()) {
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            $errorValidation = new ErrorValidationResponse();
            return response()->json(new ErrorResource($errorValidation), $errorValidation->status);
        }
        $campaign = $this->campaignBusiness->save($request->all());
        if($campaign){
            CustomLog::debug($this->class, $metodo, json_encode($campaign));
            return new CampaignResource($campaign);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($campaign));
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
        $metodo = "show";

        $campaign = $this->campaignBusiness->retrieveById($id);
        CustomLog::debug($this->class, $metodo, json_encode($campaign));
        if($campaign){
            return new CampaignResource($campaign);
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
            'start_date' => 'required',
            'end_date' => 'required',
            'active' => 'required',
            'client_id' => 'required'
        ]);

        if($validator->fails()){
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            $errorValidation = new ErrorValidationResponse();
            return response()->json(new ErrorResource($errorValidation), $errorValidation->status);
        }

        $campaign = $this->campaignBusiness->update($request->all(), $id);
        if($campaign){
            CustomLog::debug($this->class, $metodo, json_encode($campaign));
            return new CampaignResource($campaign);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($campaign));
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function destroy($id)
    {
        $metodo = "destroy";

        $campaign = $this->campaignBusiness->delete($id);
        if($campaign){
            CustomLog::debug($this->class, $metodo, "Se elimino la campaña: ".$id);
            $deleteResponse = new DeleteResponse();
            return response()->json(new GenericResource($deleteResponse), $deleteResponse->status);
        } else {
            CustomLog::debug($this->class, $metodo, "No existe la campaña: ".$id);
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }
    }
}
