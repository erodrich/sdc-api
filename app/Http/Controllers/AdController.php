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

    public function uploadImage(Request $request, $image_type){
        $result = array();
        $result['name']= $request->file($image_type)->getClientOriginalName();
        $image_pre = $request->file($image_type)->getRealPath();
        Cloudder::upload($image_pre, null);
        list($width, $height) = getimagesize($image_pre);
        $result['public_id'] = Cloudder::getPublicId();
        $result['url']= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);

        return $result;
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
        $image_pre = null;
        $this->log->debug($method, 'Se recibio: '.$request);
        if($request->file('image_pre')){
            $image_pre = $this->uploadImage($request, 'image_pre');
        }
        $image_full = null;
        if($request->file('image_full')){
            $image_full = $this->uploadImage($request, 'image_full');
        }

        $campaign = \App\Campaign::find($request->campaign_id);
        try{
            if($campaign){
                $ad = new \App\Ad;
                $ad->title = $request->title;
                $ad->description = $request->description;
                $ad->image_full_name = $image_full ? $image_full['name'] : null;
                $ad->image_full_url = $image_full ? $image_full['url'] : null;
                $ad->image_full_public_id = $image_full ? $image_full['public_id'] : null;
                $ad->image_pre_name = $image_pre ? $image_pre['name'] : null;
                $ad->image_pre_url = $image_pre ? $image_pre['url'] : null;
                $ad->image_pre_public_id = $image_pre ? $image_pre['public_id'] : null;
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

            
        $method = 'store';
        $image_pre = null;
        $this->log->debug($method, 'Se recibio: '.$request);
        if($request->file('image_pre')){
            $image_pre = $this->uploadImage($request, 'image_pre');
        }
        $image_full = null;
        if($request->file('image_full')){
            $image_full = $this->uploadImage($request, 'image_full');
        }

        $campaign = \App\Campaign::find($request->campaign_id);
        try{
            if($campaign){
                $ad = $campaign->ads()->find($id);
                if($ad){
                    $ad->title = $request->title;
                    $ad->description = $request->description;
                    $ad->image_full_name = $image_full ? $image_full['name'] : $ad->image_full_name;
                    $ad->image_full_url = $image_full ? $image_full['url'] : $ad->image_full_url;
                    $ad->image_full_public_id = $image_full ? $image_full['public_id'] : $ad->image_full_public_id;
                    $ad->image_pre_name = $image_pre ? $image_pre['name'] : $ad->image_pre_name;
                    $ad->image_pre_url = $image_pre ? $image_pre['url'] : $ad->image_pre_url;
                    $ad->image_pre_public_id = $image_pre ? $image_pre['public_id'] : $ad->image_pre_public_id;
                    $ad->video_url = $request->video_url;
                    $ad->link_url = $request->link_url;
                    $campaign->ads()->save($ad);
                    $ad->save();
                    return new AdResource($ad);
                } else {
                    return response()->json('El anuncio no existe', 400);
                }
            } else {
                return response()->json('La campaña no existe', 400); 
            }
        } catch (Exception $ex) {
            $this->log->debug($method, 'Error: '.$ex);
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
            Cloudder::destroyImage($ad->image_pre_public_id, null);
            Cloudder::delete($ad->image_pre_public_id, null);
            Cloudder::destroyImage($ad->image_full_public_id, null);
            Cloudder::delete($ad->image_full_public_id, null);
            $ad->delete();
            return response()->json('Elemento eliminado', 204);
        }		
		
    }
}
