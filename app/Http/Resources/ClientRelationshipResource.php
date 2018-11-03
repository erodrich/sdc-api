<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        
        return [
            'campaigns' => (new ClientCampaignsRelationshipResource($this->campaigns))->additional(['client' => $this]),
            'beacons' => (new ClientBeaconsRelationshipResource($this->beacons))->additional(['client' => $this]),
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
