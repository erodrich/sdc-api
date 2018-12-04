<?php

namespace App\Sdc\Business;

use App\Sdc\Repositories\ClientRepositoryInterface;

class ClientBusiness
{

    protected $clientDao;
    protected $class = "ClientBusiness";

    public function __construct(ClientRepositoryInterface $clientDao)
    {
        $this->clientDao = $clientDao;
    }

    public function retrieveAll()
    {
        $clients = $this->clientDao->retrieveAll();
        return $clients;
    }

    public function save($data)
    {
        $client = $this->clientDao->save($data);
        return $client;
    }

    public function retrieveById($id)
    {
        $client = $this->clientDao->retrieveById($id);
        return $client;
    }

    public function update($data, $id)
    {
        $client = $this->clientDao->update($data, $id);
        return $client;
    }

    public function delete($id){
        return $this->clientDao->delete($id);
    }

}
