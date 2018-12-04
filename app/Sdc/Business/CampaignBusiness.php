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
}
