<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Sdc\Business\AdBusiness;
use App\Sdc\Business\BeaconBusiness;
use App\Sdc\Repositories\AdRepositoryInterface;
use App\Sdc\Repositories\BeaconRepositoryInterface;
use App\Sdc\Responses\ErrorNotFoundResponse;
use Illuminate\Http\Request;
use App\Http\Resources\AdsResource;
use App\Http\Resources\AdResource;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;
use App\Sdc\Utilities\CustomLog;
use App\Campaign;
use App\Client;
use App\Beacon;

class CampaignRelationshipController extends Controller
{
    protected $class = "CampaignRelationshipController";
    protected $adBusiness;
    protected $beaconBusiness;

    public function __construct(AdRepositoryInterface $adDao, BeaconRepositoryInterface $beaconDao)
    {
        $this->adBusiness = new AdBusiness($adDao);
        $this->beaconBusiness = new BeaconBusiness($beaconDao);
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
    public function beacons(int $client, int $campaign)
    {
        $metodo = "beacons";
        $beacons = $this->beaconBusiness->retrieveCampaignBeacons($client, $campaign);
        CustomLog::debug($this->class, $metodo, json_encode($beacons));
        if($beacons){
            return new BeaconsResource($beacons);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }
    }
    public function beacon(int $client, int $campaign, int $beacon){
        $metodo = "beacon";
        $beacon = $this->beaconBusiness->retrieveCampaignBeacon($client, $campaign, $beacon);
        CustomLog::debug($this->class, $metodo, json_encode($beacon));
        if($beacon){
            return new BeaconResource($beacon);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }
    }
}
