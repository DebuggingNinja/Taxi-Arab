<?php

namespace App\Broadcasting;

use App\Events\RideEvent;
use App\Models\Driver;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RideSearchChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(Driver $driver, $driverId)
    {
        return
            driver_auth()->check() &&
            $driverId == driver_auth()->id() &&
            driver_auth()->user()->is_verified &&
            driver_auth()->user()->accepting_rides &&
            !driver_auth()->user()->is_blocked;
    }
}
