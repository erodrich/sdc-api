<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Ad;
use App\Http\Resources\Ad as AdResource;

class AdsController extends Controller
{
    //
    /**
     * Display the specified resource.
     * @param  String  $id
     * @return \Illuminate\Http\Response
     */
    public function getAd($id)
    {
        $beacon = Beacon::where("hw_id", $id)->first();

        $ad = $beacon->ad()->get()->first();;
        //return new LocationResource($location);
        //return LocationResource::collection($locations);
        return new AdResource($ad);
    }
}
