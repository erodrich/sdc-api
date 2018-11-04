<?php

namespace App\Sdc\Repositories;

interface BeaconRepositoryInterface extends BaseRepositoryInterface{

    public function retrieveClientBeacons(int $client);
    public function retrieveClientBeacon(int $client, int $beacon);

}