<?php

namespace App\Http\Controllers;

use App\Sdc\Utilities\Constants;
use App\Sdc\Utilities\CustomLog;
use Illuminate\Http\Request;
use App\Http\Resources\AdResource;
use Illuminate\Support\Facades\Validator;
use App\Sdc\Repositories\AdRepositoryInterface;
use Exception;

/**
 * @property AdRepositoryInterface adDao
 */
class AdController extends Controller
{
    protected $class = "AdController";
    protected $adDao;

    public function __construct(AdRepositoryInterface $adDao)
    {
        $this->adDao = $adDao;
    }

    public function index(int $campaign)
    {
        //
		$ads = $this->adDao->retrieveAds($campaign);
		return AdResource::collection($ads);
		
    }

    public function store(Request $request)
    {
        $metodo = 'store';

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if($validator->fails()){
            CustomLog::debug($this->class, $metodo, "Fallo en la validacion de: ".json_encode($request->all()));
            return response()->json(Constants::RESPONSE_BAD_REQUEST, Constants::CODE_BAD_REQUEST);
        }
        $ad = $this->adDao->save($request->all());
        if($ad){
            CustomLog::debug($this->class, $metodo, json_encode($ad));
            return response()->json($ad);
            //return new AdResource($ad);
        } else {
            CustomLog::debug($this->class, $metodo, json_encode($ad));
            return response()->json(Constants::RESPONSE_SERVER_ERROR, Constants::CODE_SERVER_ERROR);
        }

    }


    public function show(int $ad)
    {
        //
        $metodo = "show";

        $ad = $this->adDao->retrieveById($ad);
        CustomLog::debug($this->class, $metodo, json_encode($ad));
        if($ad){
            return new AdResource($ad);
        } else {
            return response()->json(Constants::RESPONSE_NOT_FOUND, Constants::CODE_BAD_REQUEST);
        }

    }


    public function update(Request $request, $id)
    {

            
        $method = 'store';
        $image_pre = null;
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
                    $ad->content = $request->content;
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
