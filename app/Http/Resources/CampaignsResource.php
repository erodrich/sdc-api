<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CampaignsResource extends ResourceCollection
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
            'data' => CampaignResource::collection($this->collection),
        ];
    }
    /*
    public function with($request)
    {
        $ads = $this->collection->flatMap(
            function ($campaign) {
                return $campaign->ads;
            }
        );
        $included = $ads->unique('id');

        return [
            'links' => [
                'self' => route('campaigns.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }

    private function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                if ($include instanceof Ad) {
                    return new AdResource($include);
                }
            }
        );
    }
    */
}
