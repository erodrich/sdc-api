<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\Http\Resources\CampaignResource;
use App\Client;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client)
    {
        //
        //$campaigns = Campaign::where('client_id', '=', $client->id)->get();
        $campaigns = $client->campaigns()->get();
		return CampaignResource::collection($campaigns);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Client $client, Request $request)
    {
        //
		$campaign = new Campaign;
		$campaign->name = $request->input('name');
		$campaign->start_date = $request->input('start_date');
		$campaign->end_date = $request->input('end_date');
		$campaign->active = $request->input('active');

		if($client->campaigns()->save($campaign)){
			return new CampaignResource($campaign->fresh());
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, $id)
    {
        //
		$campaign = Campaign::findOrFail($id);
		if($campaign->client_id == $client->id){
			return new CampaignResource($campaign);
		}
		return response()->json(['error'=>'Resource not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Client $client, Request $request, $id)
    {
        //
		$campaign = Campaign::findOrFail($id);
		$campaign->name = $request->input('name');
		$campaign->start_date = $request->input('start_date');
		$campaign->end_date = $request->input('end_date');
		$campaign->active = $request->input('active');

		if($client->campaigns()->save($campaign)){
			return new CampaignResource($campaign->fresh());
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$campaign = Campaign::findOrFail($id);
		$campaign->delete();
		return response()->json('No existe el elemento', 204);
    }
}
