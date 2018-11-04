<?php

namespace App\Sdc\Repositories;

use App\Beacon;
use App\Sdc\Utilities\CustomLog;

class BeaconRepositoryImpl implements BeaconRepositoryInterface
{
    protected $class = "BeaconRepositoryImpl";
    protected $beacon;

    public function __construct(){
        $this->beacon = new Beacon();
    }

    public function retrieveAll()
    {
        return $this->beacon->all();
    }

    public function retrieveById(int $id)
    {
        try{
            return $this->beacon->find($id);
        } catch (Exception $ex)
        {
            return null;
        }

    }

    public function save(array $data)
    {
        $metodo = "save";
        CustomLog::debug($this->class, $metodo, json_encode($data));
        try {
            $this->beacon->hw_id = $data['hw_id'];
            $this->beacon->alias = $data['alias'];
            $this->beacon->ubicacion = $data['ubicacion'];
            if(array_key_exists('client_id', $data)){
                $this->beacon->client_id = $data['client_id'];
            }
            $this->beacon->save();
            CustomLog::debug($this->class, $metodo, "Se guardo el beacon: ".json_encode($this->beacon));
            return $this->beacon;
        } catch (Exception $ex) {
            CustomLog::error($this->class, $metodo, json_encode($ex));
            return null;
        }
    }

    public function update(array $data, int $id)
    {
        $metodo = "update";
        CustomLog::debug($this->class, $metodo, "Input: ".json_encode($data));
        try{
            $this->beacon = $this->beacon->findOrFail($id);
            if($this->beacon){
                $this->beacon->hw_id = $data['hw_id'];
                $this->beacon->alias = $data['alias'];
                $this->beacon->ubicacion = $data['ubicacion'];
                if(array_key_exists('client_id', $data)){
                    $this->beacon->client_id = $data['client_id'];
                }
                if(array_key_exists('campaign_id', $data)){
                    $campaignDao = new CampaignRepositoryImpl();
                    $campaign = $campaignDao->find($data['campaign_id']);
                    if($campaign && ($campaign->client_id == $this->beacon->client_id)){
                        $this->beacon->campaign_id = $data['campaign_id'];
                    } else {
                        CustomLog::debug($this->class, $metodo, "Campaign no existe o no pertence al cliente del beacon");
                    }

                }
                $this->beacon->save();
                CustomLog::debug($this->class, $metodo, "Se actualizo el beacon: ".json_encode($this->beacon));
                return $this->beacon;
            }
        } catch (Exception $ex) {
            CustomLog::error($this->class, $metodo, "Error: ".json_encode($ex));
            return null;
        }
    }

    public function delete(int $id)
    {
        $this->beacon = $this->beacon->find($id);
        if($this->beacon){
            $this->beacon->delete();
            return true;
        }
        return false;
    }

    public function retrieveClientBeacons(int $client)
    {
        try{
            $client = Client::find($client);
            $beacons = $client ? $client->beacons()->orderBy('id','desc')->get() : null;
            return $beacons;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function retrieveClientBeacon(int $client, int $id)
    {
        try{
            $client = Client::find($client);
            $beacon = $client ? $client->campaigns()->find($id) : null;
            if($beacon){
                return $beacon;
            }
        } catch (Exception $ex) {
            return null;
        }
    }
}