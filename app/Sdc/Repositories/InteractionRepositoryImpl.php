<?php

namespace App\Sdc\Repositories;

use App\Interaction;
use App\Sdc\Utilities\Constants;
use App\Sdc\Utilities\CustomLog;
use Exception;
use Illuminate\Support\Facades\DB;

class InteractionRepositoryImpl implements InteractionRepositoryInterface
{
    protected $class = "InteractionRepositoryImpl";
    protected $interaction;

    public function __construct(){
        $this->interaction = new Interaction();
    }

    public function retrieveAll(){

        return $this->interaction->all()->paginate(Constants::ITEMS_PER_LIST);
    }

    public function retrieveById(int $id){
        try{
            return $this->interaction->find($id);
        } catch (Exception $ex) {
            return null;
        }

    }

    public function retrieveByParams(int $client_id, array $params){
        try{
            //$interactions = DB::table('interactions')->where('client_id','=',$client_id);
            $interactions = $this->interaction->where('client_id', '=', $client_id);
            if($interactions){
                foreach($params as $key=>$value){
                    $interactions->where($key, '=', $value );
                }
            }

            return $interactions->paginate(Constants::ITEMS_PER_LIST);

        } catch (Exception $ex) {
            return null;
        }
    }

    public function save(array $data){
        $metodo = "save";
        CustomLog::debug($this->class, $metodo, json_encode($data));
        try{
            $this->interaction->user_id = $data['user_id'];
            $this->interaction->campaign_id = $data['campaign_id'];
            $this->interaction->ad_id = $data['ad_id'];
            $this->interaction->client_id = $data['client_id'];
            $this->interaction->beacon_id = $data['beacon_id'];
            $this->interaction->action = $data['action'];
            $this->interaction->fecha_hora = $data['fecha_hora'];
            $this->interaction->save();
            CustomLog::debug($this->class, $metodo, "Se guardo la interaccion: ".json_encode($this->interaction));
            return $this->interaction;
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
            $this->interaction = $this->interaction->findOrFail($id);
            if($this->interaction){
                $this->interaction->user_id = $data['user_id'];
                $this->interaction->campaign_id = $data['campaign_id'];
                $this->interaction->ad_id = $data['ad_id'];
                $this->interaction->client_id = $data['client_id'];
                $this->interaction->action = $data['action'];
                $this->interaction->fecha_hora = $data['fecha_hora'];
                $this->interaction->save();
                CustomLog::debug($this->class, $metodo, "Se actualizo la interaccion: ".json_encode($this->interaction));
                return $this->interaction;
            } else {
                CustomLog::debug($this->class, $metodo, "No existe la interaccion: ".$id);
                return null;
            }
        }
        catch(Exception $ex) {
            CustomLog::error($this->class, $metodo, json_encode($ex));
            return null;
        }
    }

    public function delete(int $id){
        $this->interaction = $this->interaction->find($id);
        if($this->interaction){
            $this->interaction->delete();
            return true;
        }
        return false;
    }
}
