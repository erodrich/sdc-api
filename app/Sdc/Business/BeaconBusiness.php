<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/8/18
 * Time: 11:40 PM
 */

namespace App\Sdc\Business;

use App\Sdc\Repositories\BeaconRepositoryInterface;

class BeaconBusiness
{
    protected $class = "BeaconBusiness";
    protected $beaconDao;

    public function __construct(BeaconRepositoryInterface $beaconDao)
    {
        $this->beaconDao = $beaconDao;
    }

    public function retrieveAll()
    {
        $beacons = $this->beaconDao->retrieveAll();
        return $beacons;
    }

    public function save($data)
    {
        $beacon = $this->beaconDao->save($data);
        return $beacon;
    }

    public function retrieveById($id)
    {
        $beacon = $this->beaconDao->retrieveById($id);
        return $beacon;
    }

    public function update($data, $id)
    {
        $beacon = $this->beaconDao->update($data, $id);
        return $beacon;
    }

    public function delete($id){
        return $this->beaconDao->delete($id);
    }

    public function retrieveCampaignBeacons(int $client, int $campaign)
    {
        return $this->beaconDao->retrieveCampaignBeacons($client, $campaign);
    }

    public function retrieveCampaignBeacon(int $client, int $campaign, int $beacon)
    {
        return $this->beaconDao->retrieveCampaignBeacon($client, $campaign, $beacon);
    }

    public function retrieveClientBeacons(int $client)
    {
        return $this->beaconDao->retrieveClientBeacons($client);
    }

    public function retrieveClientBeacon(int $client, int $beacon)
    {
        return $this->beaconDao->retrieveClientBeacon($client, $beacon);
    }
}
