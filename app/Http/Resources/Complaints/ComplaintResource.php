<?php

namespace App\Http\Resources\Complaints;

use App\Http\Resources\Drivers\DriverResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
            'user' => $this->whenLoaded('user', fn() => new UserResource($this->user)),
            'driver' => $this->whenLoaded('driver', fn() => new DriverResource($this->driver)),
            'content' => $this->content,
            'is_resolved' => (bool) $this->is_resolved
        ];
    }
}
