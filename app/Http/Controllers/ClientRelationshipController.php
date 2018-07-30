<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CampaignsResource;
use App\Http\Resources\BeaconsResource;
use App\Client;

class ClientRelationshipController extends Controller
{
    //
    public function campaigns(Client $client)
    {
        return new CampaignsResource($client->campaigns);
    }
    public function beacons(Client $client)
    {
        return new BeaconsResource($client->beacons);
    }
}
