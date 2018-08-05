<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Client;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CampaignsResource;

class ClientRelationshipController extends Controller
{
    //
    public function campaigns(Client $client)
    {
        return new CampaignsResource($client->campaigns);
    }
    public function campaign(Client $client, Campaign $campaign)
    {
        $result = $client->campaigns()->find($campaign->id);
        if($result){
            return new CampaignResource($result);
        }
        return null;

    }
    public function beacons(Client $client)
    {
        return new BeaconsResource($client->beacons);
    }
}
