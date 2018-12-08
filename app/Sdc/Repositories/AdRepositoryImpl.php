<?php

namespace App\Sdc\Repositories;

use App\Ad;
use App\Campaign;
use App\Client;
use App\Sdc\Utilities\CustomLog;
use Exception;

class AdRepositoryImpl implements AdRepositoryInterface
{
    protected $class = "AdRepositoryImpl";
    protected $ad;

    public function __construct()
    {
        $this->ad = new Ad();
    }

    public function retrieveCampaignAds(int $client, int $campaign)
    {
        $method = "retrieveCampaignAds";
        try{
            $client = Client::find($client);
            $campaign = $client ? $client->campaigns()->find($campaign) : null;
            $ads = $campaign ? $campaign->ads()->orderBy('id','desc')->get() : null;
            return $ads;
        } catch (Exception $ex) {
            return null;
        }

    }

    public function retrieveCampaignAd(int $client, int $campaign, int $ad)
    {
        $method = "retrieveCampaignAd";
        try{
            $client = Client::find($client);
            $campaign = $client ? $client->campaigns()->find($campaign) : null;
            $ad = $campaign ? $campaign->ads()->find($ad) : null;
            return $ad;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function retrieveAll()
    {
        return $this->ad->all();
    }

    public function retrieveById(int $id)
    {
        try {
            return $this->ad->find($id);
        } catch (Exception $ex) {
            return null;
        }
    }

    public function save(array $data)
    {
        $method = 'store';

        $image_pre = $this->ad->uploadImage($data, 'image_pre');
        $image_full = $this->ad->uploadImage($data, 'image_full');

        $campaign = \App\Campaign::find($data['campaign_id']);
        try {
            if ($campaign) {
                $this->ad = new \App\Ad;
                $this->ad->title = $data['title'];
                $this->ad->description = $data['description'];
                $this->ad->body = $data['body'];
                $this->ad->image_full_name = $image_full ? $image_full['name'] : null;
                $this->ad->image_full_url = $image_full ? $image_full['url'] : null;
                $this->ad->image_full_public_id = $image_full ? $image_full['public_id'] : null;
                $this->ad->image_pre_name = $image_pre ? $image_pre['name'] : null;
                $this->ad->image_pre_url = $image_pre ? $image_pre['url'] : null;
                $this->ad->image_pre_public_id = $image_pre ? $image_pre['public_id'] : null;
                $this->ad->video_url = $data['video_url'];
                $this->ad->link_url = $data['link_url'];
                $campaign->ads()->save($this->ad);
                $this->ad->save();
                return $this->ad;
            } else {
                return response()->json('La campaña no existe', 400);
            }
        } catch (Exception $ex) {
            //$this->log->debug($method, 'Error: ' . $ex);
            CustomLog::error($this->class, $method, $ex->getMessage());
        }

    }

    public function update(array $data, int $id)
    {
        $metodo = "update";

        $image_pre = $this->ad->uploadImage($data, 'image_pre');
        $image_full = $this->ad->uploadImage($data, 'image_full');

        CustomLog::debug($this->class, $metodo, json_encode($data));

        try {
            $campaign = \App\Campaign::find($data['campaign_id']);
            if ($campaign) {
                $this->ad = $campaign-ads()->find($id);
                if($this->ad){
                    $this->ad->title = $data['title'];
                    $this->ad->description = $data['description'];
                    $this->ad->body = $data['body'];
                    $this->ad->image_full_name = $image_full ? $image_full['name'] : null;
                    $this->ad->image_full_url = $image_full ? $image_full['url'] : null;
                    $this->ad->image_full_public_id = $image_full ? $image_full['public_id'] : null;
                    $this->ad->image_pre_name = $image_pre ? $image_pre['name'] : null;
                    $this->ad->image_pre_url = $image_pre ? $image_pre['url'] : null;
                    $this->ad->image_pre_public_id = $image_pre ? $image_pre['public_id'] : null;
                    $this->ad->video_url = $data['video_url'];
                    $this->ad->link_url = $data['link_url'];
                    $campaign->ads()->save($this->ad);
                    return $this->ad;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } catch (Exception $ex) {
            return null;
        }



    }

    public function delete(int $id)
    {
        $this->ad = $this->ad->find($id);
        if($this->ad){
            $this->ad->delete();
            return true;
        }
        return false;
    }
}
