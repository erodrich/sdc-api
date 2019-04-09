<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function home_route()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function clients_path_test(){
        $response = $this->get('/api/clients');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function beacons_path_test(){
        $response = $this->get('/api/beacons');

        //$response->assertStatus(200);
        //$response->dump();
        $response->assertJsonStructure();
    }

    /**
     * @test
     */
    public function clients_campaigns_path()
    {
        $response = $this->get('/api/clients/8/campaigns');

        //$response->assertStatus(200);
        //$response->dump();
        $response->assertJsonStructure();
    }

}
