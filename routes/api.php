<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register')->name('register');
Route::middleware('auth:api')->post('/logout', 'AuthController@logout');

Route::apiResource('clients', 'ClientController');
Route::apiResource('campaigns', 'CampaignController');
Route::apiResource('beacons', 'BeaconController');
Route::apiResource('ads', 'AdController');
Route::get('getad/{id}', 'AppController@deliverAd');

//Clients - Campaigns 
Route::get(
    'clients/{client}/relationships/campaigns',
    [
        'uses' => ClientRelationshipController::class . '@campaigns',
        'as' => 'clients.relationships.campaigns',
    ]
);
Route::get(
    'clients/{client}/campaigns',
    [
        'uses' => ClientRelationshipController::class . '@campaigns',
        'as' => 'clients.campaigns',
    ]
);
Route::get(
    'clients/{client}/campaigns/{campaign}',
    [
        'uses' => ClientRelationshipController::class . '@campaign',
        'as' => 'clients.campaigns.show',
    ]
);

/** Clients - Beacons */
Route::get(
    'clients/{client}/relationships/beacons',
    [
        'uses' => ClientRelationshipController::class . '@beacons',
        'as' => 'clients.relationships.beacons',
    ]
);
Route::get(
    'clients/{client}/beacons',
    [
        'uses' => ClientRelationshipController::class . '@beacons',
        'as' => 'clients.beacons',
    ]
);
Route::get(
    'clients/{client}/beacons/{beacon}',
    [
        'uses' => ClientRelationshipController::class . '@beacon',
        'as' => 'clients.beacons.show',
    ]
);

/** Campaign - Ads */
Route::get(
    'clients/{client}/campaigns/{campaign}/relationships/ads',
    [
        'uses' => CampaignRelationshipController::class . '@ads',
        'as' => 'clients.campaigns.relationships.ads',
    ]
);
Route::get(
    'clients/{client}/campaigns/{campaign}/ads',
    [
        'uses' => CampaignRelationshipController::class . '@ads',
        'as' => 'clients.campaigns.ads',
    ]
);
Route::get(
    'clients/{client}/campaigns/{campaign}/ads/{ad}',
    [
        'uses' => CampaignRelationshipController::class . '@ad',
        'as' => 'clients.campaigns.ads.show',
    ]
);
/** Campaign - Beacons */
Route::get(
    'clients/{client}/campaigns/{campaign}/relationships/beacons',
    [
        'uses' => CampaignRelationshipController::class . '@beacons',
        'as' => 'clients.campaigns.relationships.beacons',
    ]
);
Route::get(
    'clients/{client}/campaigns/{campaign}/beacons',
    [
        'uses' => CampaignRelationshipController::class . '@beacons',
        'as' => 'clients.campaigns.beacons',
    ]
);
Route::get(
    'clients/{client}/campaigns/{campaign}/beacons/{beacon}',
    [
        'uses' => CampaignRelationshipController::class . '@beacon',
        'as' => 'clients.campaigns.beacons.show',
    ]
);


