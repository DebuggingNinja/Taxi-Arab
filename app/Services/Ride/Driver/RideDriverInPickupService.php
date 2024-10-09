<?php

namespace App\Services\Ride\Driver;

use App\Enums\RideStatusEnum;
use App\Events\DriverAtPickupEvent;
use App\Models\Location;
use App\Models\Ride;
use App\Services\Firebase;
use App\Services\LocationService;

class RideDriverInPickupService
{

    public function driverInPickup($latitude, $longitude)
    {
        $ride = Ride::with(['user', 'driver'])->where([
            ['driver_id', driver_auth()->id()],
            ['status', RideStatusEnum::ACCEPTED]
        ])->find(driver_auth()->user()->active_ride_id);
        if (!$ride) abort(400, __('app.Unable to proceed: No accepted ride found for the current driver'));
        $locationId = LocationService::locate($latitude, $longitude);
        $ride->update([
            'status'                        => RideStatusEnum::AT_PICKUP,
            'driver_pickup_at'              => now(),
            'driver_pickup_location_id'     => $locationId
        ]);

        if($ride->user?->device_token)
            Firebase::init()->setToken($ride->user?->device_token)
                ->setTitle('السائق وصل الى نقطة الانطلاق')
                ->setBody('السائق وصل الى نقطة الانطلاق الان!')->send();

        broadcast(new DriverAtPickupEvent($ride->id, Location::find($locationId)));

        return [
            'status'    => true,
            'message'   => __('app.You are now at the pickup location, Get ready to provide a great ride experience!')
        ];
        // Logic :
        /**
         * Set When He is available for pickup
         * Log His Location & Time
         * Broadcast to user
         */
    }
}
