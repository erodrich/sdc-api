<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientBeaconsRelationshipResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $client = $this->additional['client'];
        return [
            'data' => BeaconIdentifierResource::collection($this->collection),
            'links' => [
                'self' => route('clients.relationships.beacons', ['client' => $client->id]),
                'related' => route('clients.beacons', ['client' => $client->id]),
            ],
        ];

    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('clients.index'),
            ],
        ];
    }
}
