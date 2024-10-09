<?php

namespace App\Http\Resources\Users\Invitations;

use App\Http\Resources\Locations\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class inviteStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status'            => $this->status,
            'driver_location'   => new LocationResource($this->driver?->location),
            'expired_at'        => $this->expired_at,
            'expiry_seconds'    => getSetting('INVITE_EXPIRY_TIMEOUT')
        ];
    }
}
