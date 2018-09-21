<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CampaignAdsRelationshipResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $campaign = $this->additional['campaign'];
        return [
            'data' => AdIdentifierResource::collection($this->collection),
            'links' => [
                'self' => route('clients.campaigns.relationships.ads', ['client'=>$campaign->client_id, 'campaign' => $campaign->id]),
                'related' => route('clients.campaigns.ads', ['client'=>$campaign->client_id, 'campaign' => $campaign->id]),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('campaigns.index'),
            ],
        ];
    }
}
