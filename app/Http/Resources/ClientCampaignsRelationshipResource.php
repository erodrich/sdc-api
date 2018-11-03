<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientCampaignsRelationshipResource extends ResourceCollection
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
            'data' => CampaignIdentifierResource::collection($this->collection),
            'links' => [
                'self' => route('clients.relationships.campaigns', ['client' => $client->id]),
                'related' => route('clients.campaigns', ['client' => $client->id]),
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
