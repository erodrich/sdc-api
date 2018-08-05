<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AdsResource;
use App\Http\Resources\AdResource;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;
use App\Campaign;
use App\Client;
use App\Ad;
use App\Beacon;

class CampaignRelationshipController extends Controller
{
    //
    public function ads(Client $client, Campaign $campaign)
    {
        return new AdsResource($campaign->ads);
    }
    public function ad(Client $client, Campaign $campaign, Ad $ad){
        $result = $campaign->ads()->find($ad->id);
        if($result){
            return new AdResource($result);
        }
    }
    public function beacons(Client $client, Campaign $campaign)
    {
        return new BeaconsResource($campaign->beacons);
    }
    public function beacon(Client $client, Campaign $campaign, Beacon $beacon){
        $result = $campaign->beacons()->find($beacon->id);
        if($result){
            return new BeaconResource($result);
        }
    }
}
