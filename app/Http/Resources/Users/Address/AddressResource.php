<?php

namespace App\Http\Resources\Users\Address;

use App\Http\Resources\Locations\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id'        => $this->id,
            'label'     => $this->label,
            'address'   => $this->address,
            'location'  => new LocationResource($this->location)
        ];
    }
}
