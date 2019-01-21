<?php

namespace App\Sdc\Repositories;

use App\Ad;
use App\Campaign;
use App\Client;
use App\Sdc\Utilities\CustomLog;
use App\Sdc\Utilities\Constants;


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
        try {
            $client = Client::find($client);
            $campaign = $client ? $client->campaigns()->find($campaign) : null;
            $ads = $campaign ? $campaign->ads()->orderBy('id', 'desc')->paginate(Constants::ITEMS_PER_LIST) : null;
            return $ads;
        } catch (Exception $ex) {
            return null;
        }

    }

    public function retrieveCampaignAd(int $client, int $campaign, int $ad)
    {
        $method = "retrieveCampaignAd";
        try {
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

        $campaign = Campaign::find($data['campaign_id']);
        try {
            if ($campaign) {
                if (array_key_exists('image_pre', $data) && $data['image_pre']) {
                    $image_pre = $this->ad->uploadImage($data, 'image_pre');
                    $this->ad->image_pre_name = $image_pre ? $image_pre['name'] : null;
                    $this->ad->image_pre_url = $image_pre ? $image_pre['url'] : null;
                    $this->ad->image_pre_public_id = $image_pre ? $image_pre['public_id'] : null;
                }
                if (array_key_exists('image_full', $data) && $data['image_full']) {
                    $image_full = $this->ad->uploadImage($data, 'image_full');
                    $this->ad->image_full_name = $image_full ? $image_full['name'] : null;
                    $this->ad->image_full_url = $image_full ? $image_full['url'] : null;
                    $this->ad->image_full_public_id = $image_full ? $image_full['public_id'] : null;
                }
                $this->ad->title = $data['title'];
                $this->ad->description = $data['description'];
                $this->ad->body = $data['body'];
                $this->ad->video_url = $data['video_url'];
                $this->ad->link_url = $data['link_url'];
                $campaign->ads()->save($this->ad);
                $this->ad->save();
                return $this->ad;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            CustomLog::error($this->class, $method, $ex->getMessage());
            return null;
        }

    }

    public function update(array $data, int $id)
    {
        $metodo = "update";

        CustomLog::debug($this->class, $metodo, json_encode($data));

        try {
            $campaign = Campaign::find($data['campaign_id']);
            if ($campaign) {
                CustomLog::debug($this->class, $metodo, "Campaign: ".json_encode($campaign));
                $ad = $campaign->ads()->find($id);
                if ($ad) {
                    CustomLog::debug($this->class, $metodo, "Ad: ".json_encode($ad));

                    if (array_key_exists('image_pre', $data)) {
                        $image_pre = $this->ad->uploadImage($data, 'image_pre');
                        $ad->image_pre_name = $image_pre ? $image_pre['name'] : null;
                        $ad->image_pre_url = $image_pre ? $image_pre['url'] : null;
                        $ad->image_pre_public_id = $image_pre ? $image_pre['public_id'] : null;
                    }
                    if (array_key_exists('image_full', $data)) {
                        $image_full = $this->ad->uploadImage($data, 'image_full');
                        $ad->image_full_name = $image_full ? $image_full['name'] : null;
                        $ad->image_full_url = $image_full ? $image_full['url'] : null;
                        $ad->image_full_public_id = $image_full ? $image_full['public_id'] : null;
                    }
                    $ad->title = $data['title'];
                    $ad->description = $data['description'];
                    $ad->body = $data['body'];
                    $ad->video_url = $data['video_url'];
                    $ad->link_url = $data['link_url'];
                    $campaign->ads()->save($ad);
                    $ad->save();
                    return $ad;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } catch (Exception $ex) {
            CustomLog::debug($this->class, $metodo, $ex->getMessage());
            return null;
        }


    }

    public function delete(int $id)
    {
        $this->ad = $this->ad->find($id);
        if ($this->ad) {
            $this->ad->delete();
            return true;
        }
        return false;
    }
}
