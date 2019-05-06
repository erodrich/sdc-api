<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Sdc\Repositories\ClientRepositoryImpl;
use App\Overview;

class OverviewTest extends TestCase
{
    private $clientDao;

    public function setup(){
        parent::setUp();
        //$this->campaign = factory(Campaign::class, 10)->make();
        $this->clientDao = new ClientRepositoryImpl();
    }

    /**
     * A basic test example.
     *@test
     * @return void
     */
    public function testExample()
    {
        $response = new Overview();

        $client = $this->clientDao->retrieveById(8);
        $campaigns = $client->campaigns()->get();
        $total_ads = 0;
        foreach($campaigns as $campaign){
            $total_ads += $campaign->ads()->count();
        }
        echo(json_encode($total_ads));

        $this->assertTrue(true);
    }
}
