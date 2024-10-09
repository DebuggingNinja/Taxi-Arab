<?php

namespace App\Broadcasting;

use App\Events\RideEvent;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RidesMapChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function join(User $user)
    {
        return
            user_auth()->check() &&
            !user_auth()->user()->is_blocked;
    }
}
