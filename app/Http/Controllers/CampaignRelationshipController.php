<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Sdc\Business\AdBusiness;
use App\Sdc\Repositories\AdRepositoryInterface;
use App\Sdc\Responses\ErrorNotFoundResponse;
use Illuminate\Http\Request;
use App\Http\Resources\AdsResource;
use App\Http\Resources\AdResource;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;
use App\Sdc\Utilities\CustomLog;
use App\Campaign;
use App\Client;
use App\Ad;
use App\Beacon;

class CampaignRelationshipController extends Controller
{
    protected $class = "CampaignRelationshipController";
    protected $adBusiness;

    public function __construct(AdRepositoryInterface $adDao)
    {
        $this->adBusiness = new AdBusiness($adDao);
    }

    //Client/Campaign/Ads
    public function ads(int $client, int $campaign)
    {
        $metodo = "ads";
        $ads = $this->adBusiness->retrieveCampaignAds($client, $campaign);
        CustomLog::debug($this->class, $metodo, json_encode($ads));
        if($ads){
            return new AdsResource($ads);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }


    }
    public function ad(int $client, int $campaign, int $ad){
        $metodo = "ad";
        $ad = $this->adBusiness->retrieveCampaignAd($client, $campaign, $ad);
        CustomLog::debug($this->class, $metodo, json_encode($ad));
        if($ad){
            return new AdResource($ad);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }
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
