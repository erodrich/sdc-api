<?php

namespace App\Sdc\Repositories;

use App\Client;
use App\Sdc\Utilities\CustomLog;

class ClientRepositoryImpl implements ClientRepositoryInterface
{
    protected $class = "ClientRepositoryImpl";
    protected $client;

    public function __construct(){
        $this->client = new Client();
    }

    public function retrieveAll(){

        return $this->client->with(['campaigns', 'beacons'])->paginate();
    }

    public function retrieveById(int $id){
        try{
            return $this->client->find($id);
        } catch (Exception $ex) {
            return null;
        }
        
    }

    public function save(array $data){
        $metodo = "save";
        CustomLog::debug($this->class, $metodo, json_encode($data));
        try{
            $this->client->name = $data['name'];
            $this->client->ruc = $data['ruc'];
            $this->client->description = $data['description'];
            $this->client->save();
            CustomLog::debug($this->class, $metodo, "Se guardo el cliente: ".json_encode($this->client));
            return $this->client;
        } 
        catch(Exception $ex) {
            CustomLog::error($this->class, $metodo, json_encode($ex));
            return null; 
        }

        
    }

    public function update(array $data, int $id){
        $metodo = "update";
        CustomLog::debug($this->class, $metodo, "Input: ".json_encode($data));
        
        try{
            $this->client = $this->client->findOrFail($id);
            if($this->client){
                $this->client->name = $data['name'];
                $this->client->ruc = $data['ruc'];
                $this->client->description = $data['description'];
                $this->client->save();
                CustomLog::debug($this->class, $metodo, "Se actualizo el cliente: ".json_encode($this->client));
                return $this->client;
            } else {
                CustomLog::debug($this->class, $metodo, "No existe el cliente: ".$id);
                return null;
            }
        } 
        catch(Exception $ex) {
            CustomLog::error($this->class, $metodo, json_encode($ex));
            return null; 
        }
    }

    public function delete(int $id){
        $this->client = $this->client->find($id);
        if($this->client){
            $this->client->delete();
            return true;
        }
        return false;
    }
}