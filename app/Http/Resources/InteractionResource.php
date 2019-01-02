<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InteractionResource extends JsonResource
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
            'type' => 'Interaction',
            'id' => (string) $this->id,
            'attributes' => [
                'client_id' => $this->client_id,
                'campaign' => array('id' => $this->campaign->id, 'name' => $this->campaign->name),
                'ad' => array('id' => $this->ad->id, 'title' => $this->ad->title),
                'beacon' => array('id' => $this->beacon->id, 'alias' => $this->beacon->alias),
                'timestamp' => $this->fecha_hora,
                'action' => $this->action
            ],
        ];
    }
}
