<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'type' => 'ad',
            'id' => (string) $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->description,
                'image_full_name' => $this->image_full_name,
                'image_full_url' => $this->image_full_url,
                'image_pre_name' => $this->image_pre_name,
                'image_pre_url' => $this->image_pre_url,
                'video_url' => $this->video_url,
                'link_url' => $this->link_url,
                'created_at' => $this->created_at->toDateString(),
            ],
            'links' => [
                'self' => route('clients.campaigns.ads.show', ['client'=>$this->campaign->client_id,'campaign' => $this->campaign_id,'ad' => $this->id]),
            ],
        ];
    }
}
