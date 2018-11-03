<?php

namespace App\Sdc\Repositories;

use App\Campaign;
use App\Client;

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
        // TODO: Implement save() method.
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

    public function retrieveClientCampaigns(Client $client)
    {
        try{
            $campaigns = $client->campaigns()->orderBy('id','desc')->get();
            return $campaigns;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function retrieveClientCampaign(int $client, int $id)
    {
        try{
            $client = Client::find($client);
            $campaign = $client->campaigns()->find($id);
            if($campaign){
                return $campaign;
            }
        } catch (Exception $ex) {
            return null;
        }
    }
}