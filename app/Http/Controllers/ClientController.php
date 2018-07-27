<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Http\Resources\ClientResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = Client::all();
        return ClientResource::collection($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		
		$client = $request->isMethod('put') ? Client::findOrFail($request->id) : new Client;
		$client->name = $request->input('name');
		$client->ruc = $request->input('ruc');
		$client->description = $request->input('description');
		if($client->save()){
			return new ClientResource($client);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$client = Client::findOrFail($id);
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
		$client = Client::findOrFail($id);
		$client->name = $request->input('name');
		$client->ruc = $request->input('ruc');
		$client->description = $request->input('description');
		if($client->save()){
			return new ClientResource($client->fresh());
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$client = Client::find($id);
		$client->delete();

		return response()->json(null, 204);
    }
}
