<?php

namespace App\Http\Resources\Drivers;

use App\Http\Resources\CarType\CarTypeCollection;
use App\Http\Resources\CarType\CarTypeResource;
use App\Http\Resources\Locations\LocationResource;
use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'id'                            => $this->id,
            'name'                          => $this->name,
            'device_token'                  => $this->device_token,
            'phone_number'                  => ($this->phone_number[0] ?? false) === '0' ? $this->phone_number : "0" . $this->phone_number,
            'rating'                        => $this->AverageRating(),
            'gender'                        => $this->gender,
            'vehicle_registration_plate'    => $this->vehicle_registration_plate,
            'vehicle_color'                 => $this->vehicle_color,
            'vehicle_model'                 => $this->vehicle_model,
            'personal_image'                => $this->personal_image ? url('uploads/'.$this->personal_image) : null,
            'vehicle_image'                 => $this->vehicle_image ? url('uploads/'.$this->vehicle_image) : null,

            'latest_location_id'            => $this->whenLoaded('location', fn () => new LocationResource($this->location)),
            'car_types'                     => $this->whenLoaded('car_types', fn () => new CarTypeCollection($this->car_types)),
        ];
    }
}
