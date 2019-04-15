<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Beacon;
use App\DeliveredData;
use App\Overview;

class AdTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function testExample()
    {
        $id = 'MU70AXNS8567545448768733747HTX';
        $response = new DeliveredData();
        $beacon = Beacon::where('hw_id', '=', $id)->first();
        if ($beacon->campaign()->first()) {
            $campaign = $beacon->campaign()->first();
            try {
                /* Logica para conseguir el anuncio a mostrar */
                if ($campaign->ads()->count() > 0) {
                    $ads = $campaign->ads()->get();
                    $ad = $ads->random(1);
                }

                $response->client_id = $beacon->client_id;
                $response->beacon_id = $beacon->id;
                $response->ad = $ad;
                return $response;
            } catch (Exception $ex) {

                return null;
            }
        } else {
            return null;
        }
        $this->assertTrue(true);
    }
}
