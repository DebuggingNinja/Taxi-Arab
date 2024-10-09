<?php

namespace App\Services\Ride\User;

use App\Models\DriverRating;
use App\Models\Ride;

class RideDriverRatingService
{

    public function rate(array $data)
    {
        // You can add more validation and error handling as needed
        try {
            $driverRating = DriverRating::create([
                'user_id'   => user_auth()->id(),
                'ride_id'   => $data['ride_id'],
                'driver_id' => Ride::find($data['ride_id'])->driver_id,
                'rate'      => $data['rate'],
                'comment'   => $data['comment'] ?? null,
            ]);
            if ($driverRating) return true;
            return false;
        } catch (\Exception $e) {

            return false;
        }
    }

    public function rate4Driver(array $data)
    {
        // You can add more validation and error handling as needed
        try {
            $driverRating = DriverRating::create([
                'driver_id'   => driver_auth()->id(),
                'ride_id'   => $data['ride_id'],
                'user_id' => Ride::find($data['ride_id'])->user_id,
                'rate'      => $data['rate'],
                'comment'   => $data['comment'] ?? null,
            ]);
            if ($driverRating) return true;
            return false;
        } catch (\Exception $e) {

            return false;
        }
    }
}
