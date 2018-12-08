<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Sdc\Business\BeaconBusiness;
use App\Sdc\Business\CampaignBusiness;
use App\Sdc\Repositories\BeaconRepositoryInterface;
use App\Sdc\Repositories\CampaignRepositoryInterface;
use App\Sdc\Responses\ErrorNotFoundResponse;
use App\Sdc\Utilities\CustomLog;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CampaignsResource;

class ClientRelationshipController extends Controller
{

    protected $class = "ClientRelationshipController";
    protected $beaconBusiness;
    protected $campaignBusiness;


    /**
     * ClientRelationshipController constructor.
     * @param CampaignRepositoryInterface $campaignDao
     * @param BeaconRepositoryInterface $beaconDao
     */
    public function __construct(CampaignRepositoryInterface $campaignDao, BeaconRepositoryInterface $beaconDao)
    {
        $this->beaconBusiness = new BeaconBusiness($beaconDao);
        $this->campaignBusiness = new CampaignBusiness($campaignDao);
    }


    //
    public function campaigns(int $client)
    {
        $metodo = 'campaigns';
        $campaigns = $this->campaignBusiness->retrieveClientCampaigns($client);
        CustomLog::debug($this->class, $metodo, json_encode($campaigns));
        if($campaigns){
            return new CampaignsResource($campaigns);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }


    }

    public function campaign(int $client, int $campaign)
    {
        $metodo = 'campaign';
        $campaign = $this->campaignBusiness->retrieveClientCampaign($client, $campaign);
        CustomLog::debug($this->class, $metodo, json_encode($campaign));
        if($campaign){
            return new CampaignResource($campaign);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }


    }

    public function beacons(int $client)
    {
        $metodo = 'beacons';
        $beacons = $this->beaconBusiness->retrieveClientBeacons($client);
        CustomLog::debug($this->class, $metodo, json_encode($beacons));
        if($beacons){
            return new BeaconsResource($beacons);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }
    }

    public function beacon(int $client, int $beacon)
    {
        $metodo = 'beacon';
        $beacon = $this->beaconBusiness->retrieveClientBeacon($client, $beacon);
        CustomLog::debug($this->class, $metodo, json_encode($beacon));
        if($beacon){
            return new BeaconResource($beacon);
        } else {
            $errorNotFound = new ErrorNotFoundResponse();
            return response()->json(new ErrorResource($errorNotFound), $errorNotFound->status);
        }

    }
}
