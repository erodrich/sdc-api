<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AdsResource;
use App\Campaign;
use App\Client;

class CampaignRelationshipController extends Controller
{
    //
    public function ads(Client $client, Campaign $campaign)
    {
        return new AdsResource($campaign->ads);
    }
}
