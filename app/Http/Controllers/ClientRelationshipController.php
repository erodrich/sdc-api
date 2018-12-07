<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use App\Sdc\Business\CampaignBusiness;
use App\Sdc\Repositories\BeaconRepositoryInterface;
use App\Sdc\Repositories\CampaignRepositoryInterface;
use App\Sdc\Responses\ErrorNotFoundResponse;
use App\Sdc\Utilities\CustomLog;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CampaignsResource;
use App\Sdc\Utilities\Constants;

class ClientRelationshipController extends Controller
{

    protected $class = "ClientRelationshipController";
    protected $beaconDao;
    protected $campaignBusiness;

    public $log;

    /**
     * ClientRelationshipController constructor.
     * @param CampaignRepositoryInterface $campaignDao
     * @param BeaconRepositoryInterface $beaconDao
     */
    public function __construct(CampaignRepositoryInterface $campaignDao, BeaconRepositoryInterface $beaconDao)
    {
        $this->beaconDao = $beaconDao;
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
        $beacons = $this->beaconDao->retrieveClientBeacons($client);
        CustomLog::debug($this->class, $metodo, json_encode($beacons));
        if($beacons){
            return new BeaconsResource($beacons);
        } else {
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }
    }

    public function beacon(int $client, int $beacon)
    {
        $metodo = 'beacon';
        $beacon = $this->beaconDao->retrieveClientBeacon($client, $beacon);
        CustomLog::debug($this->class, $metodo, json_encode($beacon));
        if($beacon){
            return new BeaconResource($beacon);
        } else {
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }

    }
}
