<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\Ad;
use App\Client;
use App\Http\Resources\AdResource;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client, Campaign $campaign)
    {
        //
		$ads = $campaign->ads()->get();
		return AdResource::collection($ads);
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Client $client, Campaign $campaign, Request $request)
    {
        //
		$ad = new Ad;
		$ad->title = $request->input('title');
		$ad->subtitle = $request->input('subtitle');
		$ad->image_full_name = $request->input('image_full_name');
		$ad->image_pre_name = $request->input('image_pre_name');
		$ad->image_full_url = $request->input('image_full_url');	
		$ad->image_pre_url = $request->input('image_pre_url');
		
		if($campaign->ads()->save($ad)){
			return $ad->fresh();	
		}
		
		
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, Campaign $campaign, $id)
    {
        //
		
		$ad = $campaign->ads()->find($id);
		return new AdResource($ad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Client $client, Campaign $campaign, Request $request, $id)
    {
        //
		$ad = $campaign->ads()->find($id);
		$ad->title = $request->input('title');
		$ad->subtitle = $request->input('subtitle');
		$ad->image_full_name = $request->input('image_full_name');
		$ad->image_pre_name = $request->input('image_pre_name');
		$ad->image_full_url = $request->input('image_full_url');	
		$ad->image_pre_url = $request->input('image_pre_url');
		
		if($campaign->ads()->save($ad)){
			return $ad->fresh();	
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, Campaign $campaign, $id)
    {
        //
		$ad = $campaign->ads()->find($id);
		$ad->delete();
		return response()->json(null, 204);
    }
}
