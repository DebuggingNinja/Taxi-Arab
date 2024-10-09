<?php

namespace App\Services\Ride\User;

use App\Enums\RideInvitationStatusEnum;
use App\Enums\RideStatusEnum;
use App\Events\CancelRideEvent;
use App\Models\Driver;
use App\Models\Ride;
use App\Services\Firebase;

class RideCancelingService
{
    public function cancelRide($reason = null)
    {
        $ride = Ride::with([
            'user',
            'driver'
        ])->findOrFail(user_auth()->user()->active_ride_id);

        if (!in_array($ride->status, [RideStatusEnum::PENDING, RideStatusEnum::ACCEPTED, RideStatusEnum::AT_PICKUP]))
            return ['status' => false, 'message' => __('app.Ride status is not eligible for further action')];

        $oldStatus = $ride->status;

        broadcast(new CancelRideEvent($ride->id));
        $ride->update(['status' => RideStatusEnum::CANCELLED, 'cancelled_at' => now(), 'cancellation_reason' => $reason, 'cancelled_by' => 'user']);
        $ride->driver()->endRide();
        $user = $ride->user();
        $user->endRide();
        $userRides = Ride::with(['driver'])->where('user_id', user_auth()->id())->latest()->take(5)->get();

        if($ride->driver && $ride->driver?->device_token)
            Firebase::init()->setToken($ride->driver?->device_token)
                ->setTitle('تم إلغاء الرحلة')
                ->setBody('قام العميل بإلغاء الرحلة')->send();

        if($oldStatus == RideStatusEnum::PENDING){
            $tokens = Driver::whereNotNull('device_token')
                ->whereHas('invites', fn($q) => $q->where('ride_id', $ride->id)
                ->where('status', RideInvitationStatusEnum::PENDING)
                ->whereDate('expired_at', '>=', now()))->get()->pluck('device_token')->toArray();

            if(count($tokens))
                Firebase::init()
                    ->setTitle('تم إلغاء الرحلة')
                    ->setBody('قام العميل بإلغاء الرحلة')->sendToMany($tokens);
        }

        $consecutive_cancelled = 0;

        if($ride->driver){
            foreach ($userRides as $ride) {
                if ($ride->status != RideStatusEnum::CANCELLED || $ride->cancelled_by != 'user') break;
                $consecutive_cancelled++;
            }
            if ($consecutive_cancelled == 5) {
                $user->setBlackListed();
                return [
                    'status' => true,
                    'is_bloacked' => true,
                    'message' => __('app.Ride Cancelled Successfully, Since you have 5 consecutive cancels, Your account has been blocked')
                ];
            }
        }

        return $consecutive_cancelled ?
            ['status' => true, 'is_bloacked' => false, 'message' => __('app.Ride Cancelled Successfully, Be Aware that you have :ridesCount consecutive cancels, After 5 consecutive cancels you will get blocked automatically', ['ridesCount' => $consecutive_cancelled])] :
            ['status' => true, 'is_bloacked' => false, 'message' => __('app.Ride Cancelled Successfully')];
    }
}
