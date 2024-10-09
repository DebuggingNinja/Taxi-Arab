<?php

namespace App\Services\Ride\Driver;

use App\Enums\RideStatusEnum;
use App\Events\CancelRideEvent;
use App\Models\DriverRating;
use App\Models\Ride;
use App\Services\Firebase;
use Carbon\Carbon;

class RideCancelingService
{
    public function cancelRide($reason = null)
    {
        $ride = Ride::with([
            'user',
            'driver',
        ])->findOrFail(driver_auth()->user()->active_ride_id);

        if (!in_array($ride->status, [RideStatusEnum::PENDING, RideStatusEnum::ACCEPTED, RideStatusEnum::AT_PICKUP]))
            return ['status' => false, 'message' => __('app.Ride status is not eligible for further action')];

        $update = [
            'status' => RideStatusEnum::CANCELLED,
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
            'cancelled_by' => 'driver'
        ];

        $acceptDifference = $ride->accepted_at->diffInMinutes(now());
        $pickupDifference = $ride->driver_pickup_at ? $ride->driver_pickup_at?->diffInMinutes(now()) ?? 10 : 10;

        $fees = ($acceptDifference < 1 || $pickupDifference <= 5) ? getSetting('CANCELLATION_FEES', 0) : 0;

        if($fees) $update['driver_cancellation_fees'] = $fees;

        $ride->update($update);

        broadcast(new CancelRideEvent($ride->id));

        $ride->driver()->endRide($fees);
        $ride->user()->endRide();

        if($ride->user?->device_token)
            Firebase::init()->setToken($ride->user?->device_token)
                ->setTitle('تم إلغاء الرحلة')
                ->setBody('قام السائق بإلغاء الرحلة')->send();

        return ['status' => true, 'is_bloacked' => false, 'message' => __('تم إلغاء الرحلة بنجاح')];
    }
}
