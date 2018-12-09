<?php

namespace App\Http\Controllers;

use App\Sdc\Business\AdBusiness;
use App\Sdc\Repositories\AdRepositoryImpl;

class AppController extends Controller
{

    public function deliverAd($id){
        $adBusiness = new AdBusiness(new AdRepositoryImpl());
        $ad = $adBusiness->deliverAd($id);
        return $ad;
    }
}
