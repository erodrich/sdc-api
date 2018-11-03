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
    //Client/Campaign/Ads
    public function ads(Client $client, Campaign $campaign)
    {
        
        if($campaign->client_id == $client->id){
            $ads = $campaign->ads;
            return new AdsResource($ads);
        }
        return ['data' => []];
        
    }
    public function ad(Client $client, Campaign $campaign, Ad $ad){
        if($campaign->client_id == $client->id){
            $ad = $campaign->ads->find($ad->id);
            if($ad){
                return new AdResource($ad);
            }
        }
        return ['data' => []];
    }

    //Client/Campaign/Beacons
    public function beacons(Client $client, Campaign $campaign)
    {
        if($campaign->client_id == $client->id){
            $beacons = $campaign->beacons;
            return new BeaconsResource($beacons);
        }
        return ['data' => []];
    }
    public function beacon(Client $client, Campaign $campaign, Beacon $beacon){
        if($campaign->client_id == $client->id){
            $beacons = $campaign->beacons->find($beacon->id);
            return new BeaconsResource($beacons);
        }
        return ['data' => []];
    }
}
