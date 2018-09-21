<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BeaconResource extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $sefl_route = route('beacons.show', ['beacon'=>$this->id]);
        if($this->campaign != null){
            $self_route = route('clients.campaigns.beacons.show', ['client'=>$this->campaign->client_id,'campaign' => $this->campaign_id,'beacon' => $this->id]);
        }

        return [
            'type' => 'beacons',
            'id' => (string) $this->id,
            'attributes' => [
                'hw_id' => $this->hw_id,
                'alias' => $this->alias,
                'ubicacion' => $this->ubicacion,
                'created_at' => $this->created_at->toDateString(),
            ],
            'links' => [
                'self' => $sefl_route,
            ],
        ];
    }
}
