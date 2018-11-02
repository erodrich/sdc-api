<?php

namespace App\Sdc\Repositories;

use App\Client;
use Illuminate\Support\Facades\Hash;
use App\Sdc\Utilities\CustomLog;

class ClientRepositoryImpl implements ClientRepositoryInterface
{
    protected $class = "ClientRepositoryImpl";

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
        $this->client->name = $data['name'];
        $this->client->ruc = $data['ruc'];
        $this->client->description = $data['description'];
        try{
            $this->client->save();
            return $this->client;
        } 
        catch(Exception $ex) {
            CustomLog::error($this->class, $metodo, json_encode($ex));
            return null; 
        }

        
    }

    public function update(array $data){

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