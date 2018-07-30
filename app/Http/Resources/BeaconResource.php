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
        return [
            'type' => 'beacons',
            'id' => (string) $this->id,
            'attributes' => [
                'hw_id' => $this->hw_id,
                'alias' => $this->alias,
                'ubicacion' => $this->ubicacion,
            ],
            'links' => [
                'self' => route('beacons.show', ['beacon' => $this->id]),
            ],
        ];
    }
}
