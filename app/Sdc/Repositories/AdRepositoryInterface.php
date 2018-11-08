<?php

namespace App\Sdc\Repositories;

interface AdRepositoryInterface extends BaseRepositoryInterface
{

    public function retrieveCampaignAds(int $client, int $campaign);

    public function retrieveCampaignAd(int $client, int $campaign, int $ad);

}