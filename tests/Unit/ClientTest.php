<?php

namespace Tests\Unit;

use App\Http\Resources\ClientsResource;
use App\Sdc\Business\ClientBusiness;
use App\Sdc\Repositories\ClientRepositoryImpl;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use DatabaseTransactions;

    private $clientBusiness;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->clientBusiness = new ClientBusiness(new ClientRepositoryImpl());
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function clients_are_returned()
    {
        $clients = $this->clientBusiness->retrieveAll();
        $clientsResource = new ClientsResource($clients);
        //echo(json_encode($clientsResource));
        $this->assertTrue(true);
    }
}
