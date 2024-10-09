<?php

namespace App\Http\Controllers\API\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LocationService;
use App\Events\DriversRealLocationEvent;
use App\Http\Resources\Drivers\Profile\ProfileResource;
use App\Models\Ride;
use App\Models\RideTracking;
use App\Events\RideTrackingEvent;


class DriverController extends Controller
{
    public function locationUpdate(Request $request)
    {
        $data = $request->validate([
            'latitude'      => 'required|numeric',
            'longitude'     => 'required|numeric',
        ]);
        $driver = driver_auth()->user();
        if (!$driver) {
            return response()->json([
                'message' => 'driver not found'
            ],404);
        }
        $driver->update([
            'latest_location_id' => LocationService::locate($request->latitude, $request->longitude)
        ]);
        broadcast(new DriversRealLocationEvent($driver, [
            "latitude" => $request->latitude,
            "longitude" => $request->longitude
        ]));

        return response()->json([
            'driver' => $driver,
            'location' => [
                "latitude" => $request->latitude,
                "longitude" => $request->longitude
            ],
            'message' => 'Location updated'
        ],200);
    }

    public function rideTraking(Request $request)
    {
        $rules = [
            'latitude'      => ['required', 'numeric'],
            'longitude'     => ['required', 'numeric'],
            'speed'         => ['required', 'numeric', 'min:0'],
            'timestamp'     => ['required', 'date_format:H:i:s']
        ];
        $data = $request->validate($rules);
        $driver = driver_auth()->user();
        $preRide = false;
        if (Ride::find($driver->active_ride_id)->started_at == null) $preRide = true;
        $driver->update([
            'latest_location_id' => LocationService::locate($request->latitude, $request->longitude)
        ]);
        $traking =  RideTracking::create([
            'ride_id'       => $driver->active_ride_id,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'speed'         => $request->speed,
            'timestamp'     => $request->timestamp,
            'is_pre_ride'   => $preRide
        ]);
        broadcast(new RideTrackingEvent($traking))->toOthers();
        return response()->json([
            'data' => $traking,
            'message' => 'traking created'
        ],200);
    }
}
