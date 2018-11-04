<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Client;
use App\Http\Resources\CampaignResource;
use App\Sdc\Utilities\Constants;
use App\Sdc\Utilities\CustomLog;
use Illuminate\Http\Request;
use App\Sdc\Repositories\CampaignRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    protected $class = "CampaignController";
    protected $campaignDao;

    public function __construct(CampaignRepositoryInterface $campaignDao)
    {
        $this->campaignDao = $campaignDao;
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

        $campaigns = $this->campaignDao->retrieveAll();
        CustomLog::debug($this->class, $metodo, json_encode($campaigns));
        return CampaignResource::collection($campaigns);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CampaignResource
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
            return response()->json(Constants::RESPONSE_BAD_REQUEST, Constants::CODE_BAD_REQUEST);
        }
        $campaign = $this->campaignDao->save($request->all());
        if($campaign){
            CustomLog::debug($this->class, $metodo, json_encode($campaign));
            return new CampaignResource($campaign);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($campaign));
            return response()->json(Constants::RESPONSE_SERVER_ERROR, Constants::CODE_SERVER_ERROR);
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CampaignResource
     */
    public function show(int $id)
    {
        $metodo = "show";

        $campaign = $this->campaignDao->retrieveById($id);
        CustomLog::debug($this->class, $metodo, json_encode($campaign));
        if($campaign){
            return new CampaignResource($campaign);
        } else {
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return CampaignResource
     */
    public function update(Request $request, $id)
    {
        //
        
        $client = \App\Client::find($request->client_id);
        if($client){
            $campaign = $client->campaigns()->find($id);
            if($campaign){
                $campaign->name = $request->name;
                $campaign->start_date = $request->start_date;
                $campaign->end_date = $request->end_date;
                $campaign->active = $request->active;
                $client->campaigns()->save($campaign);
                $campaign->save();
                return new CampaignResource($campaign);
            } else {
                return response()->json('No existe la campaña', 400);
            }
        } else {
            return response()->json('No existe el cliente', 400);
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
        //
        $campaign = Campaign::find($id);
        if($campaign){
            $campaign->delete();
            return response()->json('Elemento eliminado', 200);
        }
        return response()->json('No existe la campaña', 40);
    }
}
