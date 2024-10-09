<?php

namespace App\Http\Controllers\API\Driver\Ride;

use App\Enums\RideStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Drivers\AcceptRideRequest;

use App\Http\Requests\Drivers\Ride\DriverAtPickupRequest;
use App\Http\Requests\Drivers\Ride\EndRideRequest;
use App\Http\Requests\LocationRequest;
use App\Http\Requests\Users\Ride\RideDriverRateRequest;
use App\Http\Requests\Users\Ride\RideUserRateRequest;
use App\Http\Resources\Drivers\Ride\highlightRideInfoResource;
use App\Http\Resources\Users\Rides\RideResource;
use App\Models\Driver;
use App\Models\Ride;
use App\Services\LocationService;
use App\Services\Ride\Driver\RideAcceptService;
use App\Services\Ride\Driver\RideCancelingService;
use App\Services\Ride\Driver\RideDriverInPickupService;
use App\Services\Ride\Driver\RideEndService;
use App\Services\Ride\Driver\RideStartService;
use App\Services\Ride\RideFareCalculator;
use App\Services\Ride\User\RideDriverRatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    public function acceptRide(AcceptRideRequest $request, RideAcceptService $service)
    {
        $success = $service->accept($request);
        if ($success['status'])
            return successResponse(new HighlightRideInfoResource($success['ride'], true), $success['message']);
        return failMessageResponse($success['message']);
    }
    public function declineRide(Request $request, RideAcceptService $service)
    {
        $success = $service->declineRideInvitation($request->route('ride'));
        if ($success['status'])
            return successMessageResponse($success['message']);
        return failMessageResponse($success['message']);
    }

    public function driverInPickup(DriverAtPickupRequest $request, RideDriverInPickupService $service)
    {
        $success = $service->driverInPickup($request->latitude, $request->longitude);
        if ($success['status'] ?? false)
            return successMessageResponse($success['message']);
        return failMessageResponse(__('app.Failed to update pickup status, Please try again'));
    }

    public function startRide(Request $request, RideStartService $service)
    {
        $success = $service->start();
        if ($success) return successMessageResponse(__('app.Ride Started Successfully'));
        return failMessageResponse(__('app.Failed to Start the ride, Please try again'));
    }

    public function endRide(EndRideRequest $request, RideEndService $service)
    {
        $success = $service->endRide($request->validated());
        if ($success['status'] ?? false) return successResponse($success, __('app.Ride has been successfully ended'));
        return failMessageResponse(__('app.Failed to end the ride, Please try again'));
    }

    public function confirmPayment(Request $request)
    {
        $ride = Ride::findOrFail($request?->ride_id);
        if($ride->driver_id != driver_auth()->id())
            return failMessageResponse(__('the selected ride doesnt belong to authenticated driver'));
        if($ride->status != RideStatusEnum::COMPLETED) return failMessageResponse(__('الرحلة لم تكتمل بعد'));
        if($ride->is_paid) return failMessageResponse(__('تم إستلام النقدية مسبقا'));
        return $ride->update(['is_paid' => true]) ?
            successResponse(__('تم تأكيد إستلام النقدية'))
            : failMessageResponse(__('فشل العملية، رجاء حاول مرة اخرى'));
    }

    public function cancel(Request $request, RideCancelingService $cancelService)
    {
        $success = $cancelService->cancelRide($request?->reason);
        if ($success['status'])
            return failMessageResponse($success['message'], ['is_bloacked' => $success['is_bloacked']]);
        return failMessageResponse($success['message']);
    }

    public function rate(RideUserRateRequest $request, RideDriverRatingService $rideDriverRating)
    {
        $success = $rideDriverRating->rate4Driver($request->validated());
        if ($success) return successMessageResponse(__('تم تقييم المستخدم بنجاح'));
        return failMessageResponse(__('فشل التقييم برجاء حاول مرة اخرى'));
    }

    public function showCurrentRideInformation(Request $request)
    {
        if (!driver_auth()->user()?->active_ride_id) abort(400, 'No active rides are currently available.');
        $ride = Ride::with([
            'user',
            'driver',
            'car_type',
            'discountCard',
            '_pickup_location',
            '_dropoff_location',
        ])->findOrFail(driver_auth()->user()?->active_ride_id);
        return successResponse(new RideResource($ride));
    }

    public function setActiveForRides(LocationRequest $request)
    {
        $driver = driver_auth()->user();
        if ($driver->active_ride_id == null &&  $driver->accepting_rides == false) {

            Driver::find($driver->id)->update([
                'accepting_rides' => true,
                'latest_location_id' => LocationService::locate($request->latitude, $request->longitude)
            ]);
            return successMessageResponse(__('app.The driver has been successfully marked as available to accept rides'));
        }
        return failMessageResponse(__('app.Unable To Set available to accept rides'));
    }

    public function setNotActiveForRides(LocationRequest $request)
    {
        $driver = driver_auth()->user();
        if ($driver->active_ride_id == null &&  $driver->accepting_rides == true) {
            Driver::find($driver->id)->update([
                'accepting_rides' => false,
                'latest_location_id' => LocationService::locate($request->latitude, $request->longitude)
            ]);
            return successMessageResponse(__('app.The driver has been successfully marked as unavailable to accept rides'));
        }
        return failMessageResponse(__('app.Unable To Set unavailable to accept rides'));
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
        ])->where('driver_id', driver_auth()->id())->findOrFail($request->route('ride'));
        return successResponse(new HighlightRideInfoResource($ride));
    }
}
