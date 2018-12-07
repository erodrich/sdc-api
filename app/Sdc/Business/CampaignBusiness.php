<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/4/18
 * Time: 7:51 PM
 */

namespace App\Sdc\Business;

use App\Sdc\Repositories\CampaignRepositoryInterface;

class CampaignBusiness
{
    protected $campaignDao;
    protected $class = "CampaignBusiness";

    public function __construct(CampaignRepositoryInterface $campaignDao)
    {
        $this->campaignDao = $campaignDao;
    }

    public function retrieveAll()
    {
        $campaigns = $this->campaignDao->retrieveAll();
        return $campaigns;
    }

    public function save($data)
    {
        $campaign = $this->campaignDao->save($data);
        return $campaign;
    }

    public function retrieveById($id)
    {
        $campaign = $this->campaignDao->retrieveById($id);
        return $campaign;
    }

    public function update($data, $id)
    {
        $campaign = $this->campaignDao->update($data, $id);
        return $campaign;
    }

    public function delete($id){
        return $this->campaignDao->delete($id);
    }

    public function retrieveClientCampaigns(int $client)
    {
        return $this->campaignDao->retrieveClientCampaigns($client);
    }

    public function retrieveClientCampaign(int $client, int $campaign)
    {
        return $this->campaignDao->retrieveClientCampaign($client, $campaign);
    }
}
