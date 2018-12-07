<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/7/18
 * Time: 11:34 PM
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class GenericResource extends JsonResource
{
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'type' => 'GenericResponse',
            'attributes' => [
                'code'			=> $this->status,
                'message'		=> $this->message,
            ]
        ];
    }
}
