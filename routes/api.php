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

Route::prefix('clients/{client}')->group(function (){
	Route::apiResource('campaigns', 'CampaignController');
});

Route::prefix('clients/{client}/campaigns/{campaign}')->group(function (){
	Route::apiResource('ads','AdController');
});
Route::prefix('clients/{client}/campaigns/{campaign}')->group(function (){
	Route::get('beacons/{beacon}','BeaconController@index');
});

Route::prefix('clients/{client}')->group(function (){
	Route::apiResource('beacons','BeaconController');
});


?>
