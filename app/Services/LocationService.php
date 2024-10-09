<?php

namespace App\Services;

use App\Models\Location;

class LocationService
{

    public static function locate($latitude, $longitude)
    {
        return Location::create([
            'latitude' => $latitude,
            'longitude' => $longitude,
        ])->id;
    }
}
