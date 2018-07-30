<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CampaignRelationshipResource extends Resource
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
