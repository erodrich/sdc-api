<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientsResource;
use Illuminate\Support\Facades\Validator;

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
        //$clients = Client::all();
        //return ClientResource::collection($clients);
        return new ClientsResource(Client::with(['campaigns', 'beacons'])->paginate());

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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ruc' => 'required',
            'description' => 'required'
        ]);
         
        if ($validator->fails()) {
            return response()->json('Bad Request', 400);
        } else {
            $client = new Client;
            $client->name = $request->input('name');
            $client->ruc = $request->input('ruc');
            $client->description = $request->input('description');
            $client->save();
            return new ClientResource($client);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ruc' => 'required',
            'description' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json('Bad Request', 400);
        } else {
            $client = Client::findOrFail($id);
            $client->name = $request->input('name');
            $client->ruc = $request->input('ruc');
            $client->description = $request->input('description');
            $client->save();
            return new ClientResource($client->fresh());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
        $client = Client::find($client->id);
        if($client){
            $client->delete();
            return response()->json('Deleted', 204);
        } else {
            return response()->json('Not found', 400);
        }
		
    }
}
