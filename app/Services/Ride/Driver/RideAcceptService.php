<?php

namespace App\Services\Ride\Driver;

use App\Enums\RideInvitationStatusEnum;
use App\Enums\RideStatusEnum;
use App\Events\RideAcceptedEvent;
use App\Events\RideInviteDeclineEvent;
use App\Http\Resources\Drivers\DriverResource;
use App\Models\Driver;
use App\Models\Ride;
use App\Models\RideInvite;
use App\Services\Firebase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Broadcast;

class RideAcceptService
{
    public function accept($request)
    {
        $ride = Ride::with([
            'user',
            'driver',
            '_pickup_location',
            '_dropoff_location',
            'invitations' => function ($q) {
                $q->where(
                    [
                        ['driver_id', driver_auth()->id()],
                        ['status', RideInvitationStatusEnum::PENDING],
                        ['expired_at', '>', Carbon::now()]
                    ]
                );
            }
        ])->findOrFail($request->route('ride'));

        // Check if the driver is invited and the invitation is valid
        if ($ride->invitations->isNotEmpty())
            $ride->invitations->first()->update(['status' => RideInvitationStatusEnum::ACCEPTED]);
        else
            abort(400, __('app.Unable to proceed: You are not invited to accept this ride'));
        if ($ride->driver_id != null || $ride->status != RideStatusEnum::PENDING)
            abort(400, __('app.Ride is not available for further action'));
        if (driver_auth()->user()->current_credit_amount <= getSetting('MINIMUM_CREDIT_TO_ACCEPT_RIDE') ?? 0)
            abort(400, __('app.Unable to proceed: Insufficient credit to accept a ride'));

        if($ride->user?->device_token){
            $firebase = Firebase::init()->setToken($ride->user?->device_token)
                ->setTitle('تم الموافقة على الدعوة')
                ->setBody('قام السائق بالموافقة على الدعوة');
            if($ride->user?->is_android)
                $firebase->setData((new DriverResource(driver_auth()->user()))->resolve());
            $firebase->send();
        }

        // Update the ride status to indicate it's accepted
        $rideUpdate = $ride->update([
            'driver_id'                     => driver_auth()->id(),
            'status'                        => RideStatusEnum::ACCEPTED,
            'driver_distance_from_pickup'   => $request->driver_distance_from_pickup_in_km,
            'accepted_at'                   => now()
        ]);

        $driver = Driver::find(driver_auth()->id());

        $driverUpdate = $driver->update([
            'active_ride_id' => $ride->id,
            'accepting_rides' => false,
        ]);
        if ($rideUpdate && $driverUpdate) {

            broadcast(new RideAcceptedEvent($ride->id, $driver));
            return ['status' => true, 'ride' => $ride, 'message' => __('app.Ride accepted successfully')];
        }

        return ['status' => false, 'message' => __('app.Failed to accept the ride')];
    }

    public function declineRideInvitation($ride_id)
    {
        $invite = RideInvite::with(['ride', 'ride.user'])->where([
            'driver_id'     => driver_auth()->id(),
            'ride_id'       => $ride_id,
            'status'        => RideInvitationStatusEnum::PENDING
        ])->first();

        if ($invite) {
            $invite->update(['status' => RideInvitationStatusEnum::EXPIRED]);
            Broadcast(new RideInviteDeclineEvent($ride_id));

//            if($invite->ride?->user?->device_token)
//                Firebase::init()->setToken($invite->ride?->user?->device_token)
//                    ->setTitle('تم رفض الدعوة')
//                    ->setBody('قام السائق برفض الدعوة')->send();

            return ['status' => true, 'message' => __('app.Ride invitation has been declined successfully')];
        }
        return ['status' => false, 'message' => __('app.No invitation found for this ride, It may have already been declined or expired')];
    }
}
