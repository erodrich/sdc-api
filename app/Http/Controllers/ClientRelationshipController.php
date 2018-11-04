<?php

namespace App\Http\Controllers;

use App\Sdc\Repositories\BeaconRepositoryInterface;
use App\Sdc\Repositories\CampaignRepositoryInterface;
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
    protected $campaignDao;

    public $log;

    /**
     * ClientRelationshipController constructor.
     * @param CampaignRepositoryInterface $campaignDao
     * @param BeaconRepositoryInterface $beaconDao
     */
    public function __construct(CampaignRepositoryInterface $campaignDao, BeaconRepositoryInterface $beaconDao)
    {
        $this->beaconDao = $beaconDao;
        $this->campaignDao = $campaignDao;
    }


    //
    public function campaigns(int $client)
    {
        $metodo = 'campaigns';
        $campaigns = $this->campaignDao->retrieveClientCampaigns($client);
        CustomLog::debug($this->class, $metodo, json_encode($campaigns));
        if($campaigns){
            return new CampaignsResource($campaigns);
        } else {
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }

        
    }

    public function campaign(int $client, int $campaign)
    {
        $metodo = 'campaign';
        $campaign = $this->campaignDao->retrieveClientCampaign($client, $campaign);
        CustomLog::debug($this->class, $metodo, json_encode($campaign));
        if($campaign){
            return new CampaignResource($campaign);
        } else {
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }


    }

    public function beacons(int $client)
    {
        $method = 'beacons';
        $this->log->debug($method, $client->beacons);
        return new BeaconsResource($client->beacons);
    }

    public function beacon(int $client, int $beacon)
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
