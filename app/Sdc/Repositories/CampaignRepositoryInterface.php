<?php

namespace App\Sdc\Repositories;

use App\Client;

interface CampaignRepositoryInterface extends BaseRepositoryInterface
{

    public function retrieveClientCampaigns(int $client);
    public function retrieveClientCampaign(int $client, int $id);
}