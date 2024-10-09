<?php

namespace App\Http\Resources\Drivers\Profile;

use App\Http\Resources\CarType\CarTypeCollection;
use App\Http\Resources\CarType\CarTypeResource;
use App\Http\Resources\Locations\LocationResource;
use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    static $auto_accept = null;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!self::$auto_accept){
            self::$auto_accept = (bool) Setting::where('key_name', 'AUTO_PICK_DRIVER')->first()?->value;
        }
        return [
            'id'                            => $this->id,
            'name'                          => $this->name,
            'phone_number'                  => ($this->phone_number[0] ?? false) === '0' ? $this->phone_number : "0" . $this->phone_number,
            'rating'                        => $this->AverageRating(),
            'rides_count'                   => $this->RidesCount(),
            'gender'                        => $this->gender,
            'vehicle_registration_plate'    => $this->vehicle_registration_plate,
            'vehicle_color'                 => $this->vehicle_color,
            'vehicle_model'                 => $this->vehicle_model,
            'personal_image'                => $this->personal_image,
            'accepting_rides'               => (bool) $this->accepting_rides,
            'auto_accept_rides'             => self::$auto_accept,
            'balance'                       => $this->current_credit_amount,
            'topics'                        => $this->getTopics(),
            'latest_location'               => $this->whenLoaded('location', fn () => new LocationResource($this->location)),
            'car_types'                     => $this->whenLoaded('car_types', fn () => new CarTypeCollection($this->car_types)),
        ];
    }

    public function getTopics(): array
    {
        $topics = ['drivers'];
        $topics[] = $this->gender == "Male" ? "male_drivers" : "female_drivers";
        return $topics;
    }
}
