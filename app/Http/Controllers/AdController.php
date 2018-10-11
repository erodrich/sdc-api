<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use App\Ad;
use App\Client;
use App\Http\Resources\AdResource;
use App\Utils\SdcLog;
use JD\Cloudder\Facades\Cloudder;

class AdController extends Controller
{
    public $log;

    public function __construct()
    {
        $this->log = new \App\Utils\SDCLog('AdController');
    }
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
        $method = 'store';
        $this->log->debug($method, 'Se recibio: '.$request);

        $name_pre = $request->file('image_pre')->getClientOriginalName();
        $image_pre = $request->file('image_pre')->getRealPath();
        $this->log->debug($method, 'Image_pre: '.$request->file('image_pre')->getRealPath());
        Cloudder::upload($image_pre, null);

        $name_full = $request->file('image_full')->getClientOriginalName();
        $image_full = $request->file('image_full')->getRealPath();
        $this->log->debug($method, 'Image_full: '.$request->file('image_full')->getRealPath());
        Cloudder::upload($image_full, null);

        list($width, $height) = getimagesize($image_pre);
        $image_pre_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
        list($width, $height) = getimagesize($image_full);
        $image_full_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
 
        $campaign = \App\Campaign::find($request->campaign_id);
        try{
            if($campaign){
                $ad = new \App\Ad;
                $ad->title = $request->title;
                $ad->description = $request->description;
                $ad->image_full_name = $name_full;
                $ad->image_full_url = $image_full_url;
                $ad->image_pre_name = $name_pre;
                $ad->image_pre_url = $image_pre_url;
                $ad->video_url = $request->video_url;
                $ad->link_url = $request->link_url;
                $campaign->ads()->save($ad);
                $ad->save();
                return new AdResource($ad);
            } else {
                return response()->json('La campaña no existe', 400); 
            }
        } catch (Exception $ex) {
            $this->log->debug($method, 'Error: '.$ex);
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
        $method = 'update';
        $this->log->debug($method, 'Se recibio: '.$request);

        $name_pre = $request->file('image_pre')->getClientOriginalName();
        $image_pre = $request->file('image_pre')->getRealPath();
        Cloudder::upload($image_pre, null);

        $name_full = $request->file('image_full')->getClientOriginalName();
        $image_full = $request->file('image_full')->getRealPath();
        Cloudder::upload($image_full, null);

        list($width, $height) = getimagesize($image_pre);
        $image_pre_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);
        list($width, $height) = getimagesize($image_full);
        $image_full_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);

        $campaign = \App\Campaign::find($request->campaign_id);
        if($campaign){
            $ad = $campaign->ads()->find($id);
            if($ad){
                $ad->title = $request->title;
                $ad->description = $request->description;
                $ad->image_full_name = $name_full;
                $ad->image_full_url = $image_full_url;
                $ad->image_pre_name = $name_pre;
                $ad->image_pre_url = $image_pre_url;
                $ad->video_url = $request->video_url;
                $ad->link_url = $request->link_url;
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
