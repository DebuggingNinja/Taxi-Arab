<?php

namespace App\Rules;

use App\Models\DriverRating;
use Illuminate\Contracts\Validation\Rule;

class RideDriverRatingExists implements Rule
{
    private $rideId;
    private $driverId;

    public function __construct($rideId)
    {
        $this->rideId = $rideId;
    }

    public function passes($attribute, $value)
    {
        return !DriverRating::where('ride_id', $this->rideId)
            ->exists();
    }

    public function message()
    {
        return 'Rating for this driver on the given ride already exists.';
    }
}
