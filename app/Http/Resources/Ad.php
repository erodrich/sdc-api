<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ad extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        /*
        return [
            'id' => $this->id,
            'mac' => $this->mac,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud
        ];
        */
    }
}
