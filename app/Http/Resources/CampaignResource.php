<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'campaign',
            'id' => (string) $this->id,
            'attributes' => [
                'name' => $this->name,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'active' => $this->active,
            ],
            'relationships' => new CampaignRelationshipResource($this),
            'links' => [
                'self' => route('clients.campaigns.show', ['client'=> $this->client_id, 'campaign' => $this->id]),
            ],
        ];
    }
}
