<?php

namespace App\Http\Resources\Notifications;

use App\Http\Resources\CarType\CarTypeResource;
use App\Http\Resources\DiscountCard\DiscountCardResource;
use App\Http\Resources\Drivers\DriverResource;
use App\Http\Resources\Locations\LocationResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id'        => $this->id,
            'content'   => $this->content,
            'time'      => $this->created_at?->format('Y/m/d h:i a'),
        ];
    }
}
