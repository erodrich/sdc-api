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
    public function store(Request $request)
    {
        //
        $campaign = \App\Campaign::find($request->campaign_id);
        if($campaign){
            $ad = new \App\Ad;
            $ad->title = $request->title;
            $ad->subtitle = $request->subtitle;
            $ad->image_full_name = $request->image_full_name;
            $ad->image_pre_name = $request->image_pre_name;
            $ad->image_full_url = $request->image_full_url;
            $ad->image_pre_url = $request->image_pre_url;
            $campaign->ads()->save($ad);
            $ad->save();
            return new AdResource($ad);
        } else {
            return response()->json('La campaña no existe', 400); 
        }
		
		
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        //
		return new AdResource($ad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $campaign = \App\Campaign::find($request->campaign_id);
        if($campaign){
            $ad = $campaign->ads()->find($id);
            if($ad){
                $ad->title = $request->input('title');
                $ad->subtitle = $request->input('subtitle');
                $ad->image_full_name = $request->input('image_full_name');
                $ad->image_pre_name = $request->input('image_pre_name');
                $ad->image_full_url = $request->input('image_full_url');	
                $ad->image_pre_url = $request->input('image_pre_url');
                $campaign->ads()->save($ad);
                $ad->save();
                return new AdResource($ad);
            } else {
                return response()->json('No existe el anuncio.', 400);
            }
        } else {
            return response()->json('No existe la campaña.', 400);
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
        $ad = \App\Ad::find($id);
        if($ad){
            $ad->delete();
            return response()->json('Elemento eliminado', 204);
        }		
		
    }
}
