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
//Route::apiResource('campaigns', 'CampaignController');

Route::prefix('clients/{client}')->group(function (){
	Route::apiResource('campaigns', 'CampaignController');
});

Route::prefix('clients/{client}/campaigns/{campaign}')->group(function (){
	Route::apiResource('ads','AdController');
});




//Route::get('ads','LocationController@index');
//Route::get('getad/{id}', 'AdController@getAd');
//Beacon API routes
//Route::apiResource('beacons', 'BeaconController');
//Route::apiResource('ads', 'AdController');
//Route::post('ad','LocationController@store');

/*
Beacons
-Mostrar todos (index)
Route::get('beacons/', 'BeaconsController@index');
-Mostrar $id
Route::get('beacons/{id}', 'BeaconsController@show');
-Actualizar $beacon
Route::put('beacons/{id}', 'BeaconsController@show');
-Añadir $beacon
*/

//Ads
//-Mostrar todos
//-Mostrar $id
//-Actualizar $ad
//-Añadir $ad


