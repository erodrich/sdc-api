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

    public $log;

    public function __construct()
    {
        $this->log = new \App\Utils\SDCLog('ClientRelationshipController');
    }


    //
    public function campaigns(Client $client)
    {
        $method = 'campaigns';
        $campaigns = $client->campaigns;
        if($campaigns){

            Log::debug($this->metodo.' ::: Campaña: '.$campaigns);
            $this->log->debug($method, $campaigns);
            return new CampaignsResource($campaigns);
        }
        return ['data' => []];
        
    }

    public function campaign(Client $client, Campaign $campaign)
    {
        $method = 'campaign';
        $result = $client->campaigns->find($campaign->id);
        if($result){
            $this->log->debug($method, $campaign);
            return new CampaignResource($result);
        }
        
        return ['data' => []];

    }

    public function beacons(Client $client)
    {
        $method = 'beacons';
        $this->log->debug($method, $client->beacons);
        return new BeaconsResource($client->beacons);
    }

    public function beacon(Client $client, Beacon $beacon)
    {
        $method = 'beacon';
        $result = $client->beacons->find($beacon->id);
        if($result){
            $this->log->debug($method, $result);
            return new BeaconResource($result);
        }
        return ['data' => []];

    }
}
