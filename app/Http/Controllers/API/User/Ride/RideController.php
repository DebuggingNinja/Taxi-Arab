<?php

namespace App\Http\Controllers\API\User\Ride;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rides\CreateUserRideRequest;
use App\Http\Requests\Rides\UpfrontRideFareRequest;
use App\Http\Requests\Users\Ride\RideDriverRateRequest;
use App\Http\Resources\Users\Invitations\inviteStatusResource;
use App\Http\Resources\Users\Rides\RideResource;
use App\Models\Ride;
use App\Services\Ride\User\RideCancelingService;
use App\Services\Ride\User\RideDriverRatingService;
use App\Services\Ride\User\RideInviteService;
use App\Services\Ride\User\StartRideService;
use App\Services\Sockets\SocketSubscriptions;
use Illuminate\Http\Request;

class RideController extends Controller
{


    public function rideUpfrontFares(UpfrontRideFareRequest $request)
    {
        $startRideService = new StartRideService();
        $fare = $startRideService->estimateRidePrices(
            $request?->estimated_distance_in_km ?? null,
            $request?->gender == "Female"
        );
        return successResponse($fare);
    }


    public function create(CreateUserRideRequest $request)
    {

        $startRideService = new StartRideService();
        $ride =
            $startRideService
            ->setPickupLatitude($request->pickup_location_latitude)
            ->setPickupLongitude($request->pickup_location_longitude)
            ->setDropoffLatitude($request->dropoff_location_latitude)
            ->setDropoffLongitude($request->dropoff_location_longitude)
            ->setDistance($request->estimated_distance_in_km)
            ->setExpectedRideDuration($request->expected_ride_duration)
            ->setCarTypeId($request->car_type_id)
            ->setRideType($request->type)
            ->setDropoffLocationName($request->dropoff_location_name)
            ->setPickupLocationName($request->pickup_location_name)
            ->startRide();

        return successResponse(new RideResource($ride));
    }
    public function show(Request $request)
    {
        $ride = Ride::with([
            'user',
            'driver',
            'car_type',
            '_pickup_location',
            '_dropoff_location',
            'discountCard'
        ])->where('user_id', user_auth()->id())->findOrFail($request->route('ride'));
        return successResponse(new RideResource($ride));
    }
    public function showCurrentRideInformation(Request $request)
    {
        if (user_auth()->user()->active_ride_id == null) abort(400, 'No active rides are currently available.');
        $ride = Ride::with([
            'user',
            'driver',
            'car_type',
            'discountCard',
            '_pickup_location',
            '_dropoff_location',
        ])->findOrFail(user_auth()->user()->active_ride_id);
        return successResponse(new RideResource($ride));
    }

    public function rideChannel($user, $id)
    {
        return true;
        $ride = Ride::find($id);
        if (!$ride || !$ride->matchDriverOrUser($user->id))
            return false;
        return $user;
    }


    public function searchForDriver(RideInviteService $rideInviteService)
    {

        $invite = $rideInviteService->setRide()->sendInvite();
        if ($invite)
            return successResponse(new inviteStatusResource($invite));
        return failMessageResponse(__('app.No Available Drivers Found, Please Retry After a Few Moments'), ['retry_after' => getSetting('DRIVER_SEARCH_RETRY_INTERVAL_SECONDS') ?? 20]);
    }


    public function rateRide(RideDriverRateRequest $request, RideDriverRatingService $rideDriverRating)
    {
        $success = $rideDriverRating->rate($request->validated());
        if ($success) return successMessageResponse(__('app.Ride driver has been rated successfully'));
        return failMessageResponse(__('app.There Was a problem rating the driver try again'));
    }

    public function cancel(Request $request, RideCancelingService $cancelService)
    {
        $success = $cancelService->cancelRide($request?->reason);
        if ($success['status'])
            return successMessageResponse($success['message'], ['is_bloacked' => $success['is_bloacked']]);
        return failMessageResponse($success['message']);
    }
}
