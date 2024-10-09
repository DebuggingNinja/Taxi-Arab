<?php

namespace App\Http\Controllers\Dashboard\Rides;

use App\Enums\RideStatusEnum;
use App\Events\CancelRideEvent;
use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Services\Firebase;
use Illuminate\Http\Request;

class RidesController extends Controller
{
    public function index(request $request)
    {
        user_can('List.Ride');
        $records = Ride::with(['driver', 'user'])->Filters($request)->latest()->paginate($request->per_page ?? $request->limit ?? 10);
        return view('dashboard.rides.index', compact('records'));
    }
    public function show(request $request)
    {
        user_can('Show.Ride');
        $record = Ride::with([
            'driver', 'user', '_pickup_location',
            '_dropoff_location', 'car_type', 'driver_pickup_location'
        ])->findOrFail($request->route('ride'));
        return view('dashboard.rides.show', compact('record'));
    }

    public function cancelRide(Ride $ride)
    {
        if(in_array($ride->status, [RideStatusEnum::CANCELLED, RideStatusEnum::COMPLETED])){
            return redirect()->back()->with('Error', 'لا يمكنك الغاء رحلة ملغية او مكتملة');
        }
        user_can('Show.Ride');
        $ride->update(['status' => RideStatusEnum::CANCELLED, 'cancelled_at' => now()]);
        if($ride->user) $ride->user->update(['active_ride_id' => null]);
        if($ride->driver) $ride->driver->update(['active_ride_id' => null]);

        $tokens = [];

        if($ride->user?->device_token) $tokens[] = $ride->user?->device_token;
        if($ride->driver?->device_token) $tokens[] = $ride->driver?->device_token;

        if(count($tokens))
            Firebase::init()->setTitle('تم إلغاء الرحلة')
                ->setBody('تم إلغاء الرحلة من طرف التطبيق')
                ->sendToMany($tokens);

        broadcast(new CancelRideEvent($ride->id));
        return redirect()->back()->with('Success', 'تم إلغاء الرحلة بنجاح');
    }

}
