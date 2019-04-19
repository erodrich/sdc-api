<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OverviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'overview',
            'attributes' => [
                'client_id' => $this->client_id,
                'total_campaigns' => $this->total_campaigns,
                'active_campaigns' => $this->active_campaigns,
                'total_ads' => $this->total_ads,
                'notified_ads' => $this->notified_ads,
                'viewed_ads' => $this->viewed_ads
            ],
            'links' => [
                //'self' => route('clients.statistics', ['client' => $this->campaign->client_id, 'campaign' => $this->campaign_id, 'ad' => $this->id]),
                //'self' => route('statistics/client/{client_id}/overview', ['client_id' => $this->client_id])
            ],
        ];
    }
}
