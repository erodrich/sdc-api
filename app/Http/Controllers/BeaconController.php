<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Campaign;
use App\Beacon;
use App\Http\Resources\BeaconsResource;
use App\Http\Resources\BeaconResource;



class BeaconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		return new BeaconsResource(Beacon::get());
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
        $beacon = new Beacon;
		$beacon->hw_id = $request->input('hw_id');
		$beacon->alias = $request->input('alias');
        $beacon->ubicacion = $request->input('ubicacion');
        if($request->input('client_id') != null){
            $beacon->client_id = $request->input('client_id');
        }
		if($beacon->save()){
			return new BeaconResource($beacon);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Beacon $beacon)
    {
        //
        return new BeaconResource($beacon);

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
        $update_beacon = Beacon::findOrFail($id);
        $update_beacon->hw_id = $request->hw_id;
		$update_beacon->alias = $request->alias;
        $update_beacon->ubicacion = $request->ubicacion;
        if($request->client_id != null){
            $update_beacon->client_id = $request->client_id;
        }
        if($request->campaign_id != null){
            $campaign = \App\Campaign::find($request->campaign_id);
            if($campaign->client_id == $update_beacon->client_id){
                $update_beacon->campaign_id = $request->campaign_id;
            } else {
                // Poner log despues
            }
            
        }
		if($update_beacon->save()){
			return new BeaconResource($update_beacon);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beacon $beacon)
    {
        //
        $beacon->delete();

		return response()->json('Deleted', 204);
    }
}
