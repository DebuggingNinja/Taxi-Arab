<?php

namespace App\Http\Resources\Drivers\Ride;

use App\Http\Resources\DiscountCard\DiscountCardResource;
use App\Http\Resources\Drivers\DriverResource;
use App\Http\Resources\Locations\LocationResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class highlightRideInfoResource extends JsonResource
{

    private bool $show_users_details;

    public function __construct($resource, $show_users_details = false)
    {
        $this->show_users_details = $show_users_details;
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
            'user_name'                 => $this->user?->name,
            'pickup_location'           => new LocationResource($this->_pickup_location),
            'dropoff_location'          => new LocationResource($this->_dropoff_location),
            'expected_ride_duration'    => $this->expected_ride_duration,
            'expected_distance'         => $this->expected_distance,
            'pickup_location_name'      => $this->pickup_location_name,
            'dropoff_location_name'     => $this->dropoff_location_name,
            'ride_id'                   => $this->id,
            'status'                    => $this->status,
            'is_paid'                   => $this->is_paid,
            'cancellation_reason'       => $this->cancellation_reason,

            'distance_details'          => [
                // Distance Information
                'driver_distance_from_pickup'   => $this->driver_distance_from_pickup,
                'expected_distance'             => $this->expected_distance,
                'actual_distance'               => $this->actual_distance,
            ],

            'pickup_details'            => [
                // Pickup Information
                'pickup_location'       => $this->whenLoaded('_pickup_location', fn () => new LocationResource($this->_pickup_location)),
                'pickup_datetime'       => $this->pickup_datetime,
                'pickup_location_name'  => $this->pickup_location_name,
            ],

            'dropoff_details'           => [
                // dropoff Information
                'dropoff_location'      => $this->whenLoaded('_dropoff_location', fn () => new LocationResource($this->_dropoff_location)),
                'dropoff_datetime'      => $this->dropoff_datetime,
                'dropoff_location_name' => $this->dropoff_location_name,
            ],

            'ride_duration'             => [
                // Duration Information
                'actual_ride_duration'      => $this->actual_ride_duration,
                'expected_ride_duration'    => $this->expected_ride_duration,
            ],

            'fare_details'              => [
                // Fare Information
                'expected_total_fare'   => $this->expected_total_fare,
                'expected_driver_fare'  => $this->expected_driver_fare,
                'expected_app_fare'     => $this->expected_app_fare,
                'actual_total_fare'     => $this->actual_total_fare,
                'actual_driver_fare'    => $this->actual_driver_fare,
                'actual_app_fare'       => $this->actual_app_fare,
            ],

            'discount_data'             => [
                // discount Data
                'discount_enabled'      => $this->discount_enabled,
                'price_before_discount' => $this->price_before_discount,
                'discountCard'          => $this->whenLoaded('discountCard', fn () => new DiscountCardResource($this->discountCard)),
            ],

            'has_balance_discount'      => $this->has_balance_discount,
            'discounted_balance_amount' => $this->discounted_balance_amount,
        ];

        if($this->show_users_details){
            $response['participant_details'] = [
                'user'      => new UserResource($this->user ?? null),
                'driver'    => new DriverResource($this->driver ?? null),
            ];
        }

        return $response;
    }
}
