<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Campaign;
use App\Client;
use App\Beacon;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CampaignsResource;

class ClientRelationshipController extends Controller
{
    protected $metodo = "ClientRelationshipController";

    //
    public function campaigns(Client $client)
    {
        $campaigns = $client->campaigns;
        if($campaigns){
            Log::debug($this->metodo.' ::: Campaña: '.$campaigns);
            return new CampaignsResource($campaigns);
        }
        return ['data' => []];
        
    }

    public function campaign(Client $client, Campaign $campaign)
    {
        $result = $client->campaigns->find($campaign->id);
        if($result){
            return new CampaignResource($result);
        }
        
        return ['data' => []];

    }

    public function beacons(Client $client)
    {
        return new BeaconsResource($client->beacons);
    }

    public function beacon(Client $client, Beacon $beacon)
    {
        $result = $client->beacons->find($beacon->id);
        if($result){
            return new BeaconResource($result);
        }
        return ['data' => []];

    }
}
