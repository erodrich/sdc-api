<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Client;
use App\Http\Resources\CampaignResource;
use App\Sdc\Utilities\CustomLog;
use Illuminate\Http\Request;
use App\Sdc\Repositories\CampaignRepositoryInterface;

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
    public function index(Client $client)
    {
        //
        $metodo = "index";

        $campaigns = $this->campaignDao->retrieveClientCampaigns($client);
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
        //
        $client = \App\Client::find($request->client_id);
        if($client){
            $campaign = new \App\Campaign;
            $campaign->name = $request->name;
            $campaign->start_date = $request->start_date;
            $campaign->end_date = $request->end_date;
            $campaign->active = $request->active;
            $client->campaigns()->save($campaign);
            $campaign->save();
            return new CampaignResource($campaign);
        } else {
            return response()->json('No existe el cliente', 400);
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CampaignResource
     */
    public function show(Client $client, Campaign $campaign)
    {
        //
        Log::debug('An informational message.');
        return new CampaignResource($campaign);
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
