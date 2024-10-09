<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = parent::toArray($request);
        if($resource['phone_number'] ?? false){
            $resource['phone_number'] = ($resource['phone_number'][0] ?? false) === '0' ? $resource['phone_number'] : "0" . $resource['phone_number'];
        }
        return $resource;
    }
}
