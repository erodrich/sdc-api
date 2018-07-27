<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
			'type' => 'client',
			'id' => (string) $this->id,
			'attributes' => [
				'name' => $this->name, 
				'ruc' => $this->ruc, 
				'description' => $this->description, 
			],
		];
	
	}
}
