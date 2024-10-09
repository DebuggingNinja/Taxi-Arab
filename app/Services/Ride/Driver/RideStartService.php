<?php

namespace App\Services\Ride\Driver;

use App\Enums\RideStatusEnum;
use App\Events\RideStartedEvent;
use App\Models\Ride;
use App\Services\Firebase;

class RideStartService
{

    public function start()
    {
        $ride = Ride::with(['user'])->where([
            ['driver_id', driver_auth()->id()],
            ['status', RideStatusEnum::AT_PICKUP]
        ])->findOrFail(driver_auth()->user()->active_ride_id);

        $ride->update([
            'status'                        => RideStatusEnum::ONGOING,
            'started_at'                    => now(),
            'pickup_datetime'               => now()
        ]);

//        if(driver_auth()->user()->device_token)
//            Firebase::init()->setToken(driver_auth()->user()->device_token)
//                ->setTitle('Driver start ride')
//                ->setBody('Driver start ride, ride number (' .
//                    driver_auth()->user()->active_ride_id . ')');

        if($ride->user?->device_token)
            Firebase::init()->setToken($ride->user?->device_token)
                ->setTitle('الرحلة قد بدأت')
                ->setBody('قام السائق ببدء الرحلة')->send();

        broadcast(new RideStartedEvent($ride->id));
        return true;
    }
}
