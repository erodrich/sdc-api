<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignRelationshipResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'ads' => (new CampaignAdsRelationshipResource($this->ads))->additional(['campaign' => $this]),
            'beacons' => (new CampaignBeaconsRelationshipResource($this->beacons))->additional(['campaign' => $this]),
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
