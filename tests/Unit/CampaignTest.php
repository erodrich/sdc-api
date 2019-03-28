<?php

namespace Tests\Unit;

use App\Campaign;
use App\Http\Resources\CampaignsResource;
use App\Sdc\Business\CampaignBusiness;
use App\Sdc\Repositories\CampaignRepositoryImpl;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CampaignTest extends TestCase
{
    use DatabaseTransactions;

    private $campaign;
    private $campaignBusiness;

    public function setup(){
        parent::setUp();
        //$this->campaign = factory(Campaign::class, 10)->make();
        $this->campaignBusiness = new CampaignBusiness(new CampaignRepositoryImpl());
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function campaign_is_created()
    {

        $this->assertNotEmpty($this->campaign);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function campaign_is_return()
    {
        $campaignList = $this->campaignBusiness->retrieveAll();
        $campaignsResource = new CampaignsResource($campaignList);
        echo(json_encode($campaignsResource));
        $this->assertNotEmpty($campaignList);
    }
}
