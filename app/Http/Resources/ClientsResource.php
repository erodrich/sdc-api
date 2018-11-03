<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use App\Campaign;
use App\Beacon;

class ClientsResource extends ResourceCollection
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
            'data' => ClientResource::collection($this->collection),
        ];
    }
/*
    public function with($request)
    {
        $campaigns = $this->collection->flatMap(
            function ($client) {
                return $client->campaigns;
            }
        );
        $beacons = $this->collection->flatMap(
            function ($client) {
                return $client->beacons;
            }
        );
        
        $included = $beacons->merge($campaigns)->unique('id');

        return [
            'links' => [
                'self' => route('clients.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }
    
    private function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                if ($include instanceof Campaign) {
                    return new CampaignResource($include);
                }
                if ($include instanceof Beacon) {
                    return new BeaconResource($include);
                }
            }
        );
    }
    */
}
