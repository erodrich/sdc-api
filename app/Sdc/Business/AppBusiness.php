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
use App\Overview;
use App\Sdc\Repositories\ClientRepositoryInterface;
use App\Sdc\Repositories\InteractionRepositoryInterface;
use App\Sdc\Utilities\Constants;
use App\Sdc\Utilities\CustomLog;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class AppBusiness
{

    protected $class = "AppBusiness";
    protected $clientDao;
    protected $interactionBusiness;


    public function __construct(ClientRepositoryInterface $clientDao, InteractionRepositoryInterface $interactionDao)
    {
        $this->clientDao = $clientDao;
        $this->interactionBusiness = new InteractionBusiness($interactionDao);
    }

    public function deliverAd($id)
    {
        $metodo = "deliverAd";
        $response = new DeliveredData();
        $beacon = Beacon::where('hw_id', '=', $id)->first();
        if ($beacon->campaign()->first()) {
            try {
                /* Logica para conseguir el anuncio a mostrar */
                if ($beacon->campaign()->first()->ads()->first()) {
                    $ad = $beacon->campaign()->first()->ads()->first();
                }

                $response->client_id = $beacon->client_id;
                $response->beacon_id = $beacon->id;
                $response->ad = $ad;
                CustomLog::debug($this->class, $metodo, json_encode($response));
                return $response;
            } catch (Exception $ex) {

                CustomLog::error($this->class, $metodo, $ex->getMessage());
                return null;
            }
        } else {
            CustomLog::debug($this->class, $metodo, "No campaigns");
            return null;
        }
    }

    public function getOverview(int $client_id)
    {
        $metodo = 'getOverview';
        $response = null;
        try {
            $client = $this->clientDao->retrieveById($client_id);

            if ($client) {
                $response = new Overview();
                $response->client_id = $client->id;
                $campaigns = $client->campaigns();
                if ($campaigns) {
                    $response->total_campaigns = $campaigns->count();
                    $response->active_campaigns = $campaigns->where('active', '=', '1')->count();
                    if($response->total_campaigns > 0){
                        foreach($campaigns as $campaign){
                            $response->total_ads += $campaign->ads()->count();
                        }
                    }

                }
                return $response;
            }
        } catch (Exception $ex) {
            CustomLog::error($this->class, $metodo, $ex->getMessage());
            return null;
        }

    }

    public function search($client_id, $params_array)
    {
        $metodo = 'search';

        $response = array();


        try{
            $interactions = $this->interactionBusiness->retrieveByParams($client_id, $params_array);
/*
            if($interactions){

                $current_page = $interactions->currentPage();
                $last_page = $interactions->lastPage();
                $next_page_url = $interactions->nextPageUrl();
                $prev_page_url = $interactions->previousPageUrl();

                $data = array();
                $links = array('next' => $next_page_url, 'prev' => $prev_page_url);
                $meta = array('current_page' => $current_page, 'last_page' => $last_page);

                foreach($interactions as $interaction){
                    $deliveredData = new DeliveredData();
                    $deliveredData['id'] = $interaction->id;
                    $deliveredData['campaign'] = $interaction->campaign()->first();
                    $deliveredData['ad'] = $interaction->ad()->first();
                    $deliveredData['beacon'] = $interaction->beacon()->first();
                    $deliveredData['client_id'] = $interaction->client_id;
                    $deliveredData['action'] = $interaction->action;
                    $deliveredData['fecha_hora'] = $interaction->fecha_hora;
                    array_push($data, $deliveredData);
                }

                $response['data'] = $data;
                $response['links'] = $links;
                $response['meta'] = $meta;
            }
            CustomLog::debug($this->class, $metodo, json_encode($response));
            //dd(Collection::make($response));
            return Collection::make($response);
*/
            return $interactions;

        } catch (Exception $ex){
            CustomLog::error($this->class, $metodo, $ex->getMessage());
            return null;
        }

    }

}
