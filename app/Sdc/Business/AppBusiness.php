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
use Illuminate\Support\Facades\DB;

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
            $campaign = $beacon->campaign()->first();
            try {
                /* Logica para conseguir el anuncio a mostrar */
                if ($campaign->ads()->count() > 0) {
                    $ads = $campaign->ads()->get();
                    $ad = $ads->random(1);
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
                CustomLog::debug($this->class, $metodo, "Cliente ID: ".$client->id." :: Nombre: [".$client->name."]");
                $response = new Overview();
                $response->client_id = $client->id;
                $campaigns = $client->campaigns()->get();
                if ($campaigns) {
                    $response->total_campaigns = $campaigns->count();
                    CustomLog::debug($this->class, $metodo, "Cliente ID: ".$client->id." :: Total Campañas: [".$response->total_campaigns."]");
                    $response->active_campaigns = $campaigns->where('active', '=', '1')->count();
                    if($response->total_campaigns > 0){
                        foreach($campaigns as $campaign){
                            $response->total_ads += $campaign->ads()->count();
                        }
                        CustomLog::debug($this->class, $metodo, "Cliente ID: ".$client->id." :: Total Anuncios: [".$response->total_ads."]");
                    }

                }

                $total_notificados = DB::table('interactions')
                    ->where('client_id', '=' , $client->id)
                    ->where('action', '=', Constants::NOTIFICADO)
                    ->distinct('ad_id')
                    ->count('ad_id');
                CustomLog::debug($this->class, $metodo, "Cliente ID: ".$client->id." :: Anuncios Notificados: [".$total_notificados."]");
                $total_vistos = DB::table('interactions')
                    ->where('client_id', '=' , $client->id)
                    ->where('action', '=', Constants::VISTO)
                    ->distinct('ad_id')
                    ->count('ad_id');
                CustomLog::debug($this->class, $metodo, "Cliente ID: ".$client->id." :: Anuncios Vistos: [".$total_vistos."]");
                $response->notified_ads = $total_notificados;
                $response->viewed_ads = $total_vistos;
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

        try{
            $interactions = $this->interactionBusiness->retrieveByParams($client_id, $params_array);

            return $interactions;

        } catch (Exception $ex){
            CustomLog::error($this->class, $metodo, $ex->getMessage());
            return null;
        }

    }

}
