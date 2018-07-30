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

Route::apiResource('clients', 'ClientController');
Route::apiResource('campaigns', 'CampaignController');
Route::apiResource('beacons', 'BeaconController');

/*
Route::prefix('clients/{client}')->group(function () {
    Route::apiResource('campaigns', 'CampaignController');
});

Route::prefix('clients/{client}/campaigns/{campaign}')->group(function () {
    Route::apiResource('ads', 'AdController');
});
Route::prefix('clients/{client}/campaigns/{campaign}')->group(function () {
    Route::get('beacons/{beacon}', 'BeaconController@index');
});

Route::prefix('clients/{client}')->group(function () {
    Route::apiResource('beacons', 'BeaconController');
});
*/

//************* Relationships Routes *****/
/** Clients - Campaigns */
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
    'clients/{client}/campaigns/{campaign}',
    [
        'uses' => ClientRelationshipController::class . '@campaigns',
        'as' => 'clients.campaigns.show',
    ]
);