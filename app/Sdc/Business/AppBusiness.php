<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/7/18
 * Time: 10:51 PM
 */

namespace App\Sdc\Business;

use App\Beacon;
use App\DeliveredData;
use App\Sdc\Repositories\ClientRepositoryInterface;
use App\Sdc\Utilities\CustomLog;
use Exception;

class AppBusiness
{

    protected $class = "AppBusiness";
    protected $clientDao;


    public function __construct(ClientRepositoryInterface $clientDao)
    {
        $this->clientDao = $clientDao;
    }

    public function deliverAd($id){
        $metodo = "deliverAd";
        $response = new DeliveredData();
        $beacon = Beacon::where('hw_id', '=', $id)->first();
        if($beacon->campaign()->first()){
            try{
                /* Logica para conseguir el anuncio a mostrar */
                if($beacon->campaign()->first()->ads()->first()){
                    $ad = $beacon->campaign()->first()->ads()->first();
                }

                $response->client_id = $beacon->client_id;
                $response->beacon_id = $beacon->id;
                $response->ad = $ad;
                CustomLog::debug($this->class, $metodo, json_encode($response));
                return $response;
            }
            catch (Exception $ex){

                CustomLog::error($this->class, $metodo, $ex->getMessage());
                return null;
            }
        } else {
            CustomLog::debug($this->class, $metodo, "No campaigns");
            return null;
        }
    }

    public function getOverview(int $client_id){
        $metodo = 'getOverview';
        $response = null;
        try{
            $client = $this->clientDao->retrieveById($client_id);
            if($client){
                $response = new DeliveredData();
                $response->campaigns = $client->campaigns()->with('ads');

            }
        } catch (Exception $ex) {

        }

    }

    public function search($request){
        $metodo = 'search';


    }

}
