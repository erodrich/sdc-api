<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllPurposeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function clientFactoryTest()
    {
        $client = factory(\App\Client::class)->make();
        
        $this->assertTrue((boolean) preg_match('/^\d+$/', $client->ruc));
    
    }
}
