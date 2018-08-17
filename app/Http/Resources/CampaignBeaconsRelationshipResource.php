<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CampaignBeaconsRelationshipResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $campaign = $this->additional['campaign'];
        return [
            'data' => BeaconIdentifierResource::collection($this->collection),
            'links' => [
                'self' => route('clients.campaigns.relationships.beacons', ['client'=>$campaign->client_id, 'campaign' => $campaign->id]),
                'related' => route('clients.campaigns.beacons', ['client'=>$campaign->client_id, 'campaign' => $campaign->id]),
            ],
        ];
    }
}
