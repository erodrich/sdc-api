<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/7/18
 * Time: 10:51 PM
 */

namespace App\Sdc\Business;

use App\Sdc\Repositories\AdRepositoryInterface;
use JD\Cloudder\Facades\Cloudder;

class AdBusiness
{

    protected $class = "AdBusiness";
    protected $adDao;

    public function __construct(AdRepositoryInterface $adDao)
    {
        $this->adDao = $adDao;
    }

    public function retrieveAll()
    {
        return $this->adDao->retrieveAll();
    }

    public function save(array $data)
    {
        return $this->adDao->save($data);
    }

    public function retrieveById(int $ad)
    {
        return $this->adDao->retrieveById($ad);
    }

    public function update(array $data, $id)
    {
        return $this->adDao->update($data, $id);
    }

    public function delete($id)
    {
        $ad = $this->adDao->retrieveById($id);
        if($ad){
            if ($ad->image_pre_public_id) {
                Cloudder::destroyImage($ad->image_pre_public_id, null);
                Cloudder::delete($ad->image_pre_public_id, null);
            }
            if($ad->image_full_public_id){
                Cloudder::destroyImage($ad->image_full_public_id, null);
                Cloudder::delete($ad->image_full_public_id, null);
            }
        }

        return $this->adDao->delete($id);
    }

    public function retrieveCampaignAds(int $client, int $campaign)
    {
        return $this->adDao->retrieveCampaignAds($client, $campaign);
    }

    public function retrieveCampaignAd(int $client, int $campaign, int $ad)
    {
        return $this->adDao->retrieveCampaignAd($client, $campaign, $ad);
    }

}
