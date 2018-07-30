<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CampaignIdentifierResource extends Resource
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
            'type' => 'campaigns',
            'id' => (string) $this->id,
        ];
    }
}
