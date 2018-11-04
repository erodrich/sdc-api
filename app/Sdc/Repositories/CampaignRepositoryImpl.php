<?php

namespace App\Sdc\Repositories;

use App\Campaign;
use App\Client;
use App\Sdc\Utilities\CustomLog;

class CampaignRepositoryImpl implements CampaignRepositoryInterface
{
    protected $class = "CampaignRepositoryImpl";
    protected $campaign;

    public function __construct()
    {
        $this->campaign = new Campaign();
    }

    public function retrieveAll()
    {
        return $this->campaign->orderBy('id','desc')->get();
    }

    public function retrieveById(int $id)
    {
        try{
            return $this->campaign->find($id);
        } catch (Exception $ex) {
            return null;
        }
    }

    public function save(array $data)
    {
        //
        $metodo = "save";
        CustomLog::debug($this->class, $metodo, json_encode($data));

        $client = Client::find($data['client_id']);
        if($client){
            try{
                $this->campaign->name = $data['name'];
                $this->campaign->start_date = $data['start_date'];
                $this->campaign->end_date = $data['end_date'];
                $this->campaign->active = $data['active'] == 1 ? true : false;
                $client->campaigns()->save($this->campaign);
                $this->campaign->save();
                CustomLog::debug($this->class, $metodo, "Se guardo la campaña: ".json_encode($this->campaign));
                return $this->campaign;
            }
            catch(Exception $ex) {
                CustomLog::error($this->class, $metodo, json_encode($ex));
                return null;
            }
        } else {
            return null;
        }

    }

    public function update(array $data, int $id)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    //By Client methods

    public function retrieveClientCampaigns(int $client)
    {
        try{
            $client = Client::find($client);
            $campaigns = $client ? $client->campaigns()->orderBy('id','desc')->get() : null;
            return $campaigns;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function retrieveClientCampaign(int $client, int $id)
    {
        try{
            $client = Client::find($client);
            $campaign = $client ? $client->campaigns()->find($id) : null;
            if($campaign){
                return $campaign;
            }
        } catch (Exception $ex) {
            return null;
        }
    }
}