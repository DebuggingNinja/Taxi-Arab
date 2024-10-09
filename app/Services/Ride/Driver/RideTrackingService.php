<?php

namespace App\Services\Ride\Driver;

use App\Contracts\Sockets\SocketServiceInterface;
use App\Events\RideTrackingEvent;
use App\Helpers\ArrayValidator;
use App\Models\Ride;
use App\Models\RideTracking;
use App\Services\LocationService;
use Illuminate\Support\Facades\Log;

/**
 * Class SocketDataFetcher
 *
 */
class RideTrackingService implements SocketServiceInterface
{
    protected $request;
    public function handleSocketRequest($request)
    {
        $this->request = $request['data'];
        return $this->rideTracking();
    }


    public function rideTracking()
    {
        $driver = driver_token_authenticate($this->request['bearer']);
        if ($driver && $this->rideTrackingRequestValidator())
            broadcast(new RideTrackingEvent($this->insertTrackingRecord($driver)))->toOthers();
    }


    public function rideTrackingRequestValidator()
    {
        if (!$this->request) return false;
        $rules = [
            'latitude'      => ['required', 'numeric'],
            'longitude'     => ['required', 'numeric'],
            'speed'         => ['required', 'numeric', 'min:0'],
            'timestamp'     => ['required', 'date_format:H:i:s']
        ];
        $valid = ArrayValidator::valid($this->request, $rules);
        if ($valid)
            return true;
        return false;
    }

    public function insertTrackingRecord($driver)
    {
        $preRide = false;
        if (Ride::find($driver->active_ride_id)->started_at == null) $preRide = true;
        $driver->update([
            'latest_location_id' => LocationService::locate($this->request['latitude'], $this->request['longitude'])
        ]);
        return RideTracking::create([
            'ride_id'       => $driver->active_ride_id,
            'latitude'      => $this->request['latitude'],
            'longitude'     => $this->request['longitude'],
            'speed'         => $this->request['speed'],
            'timestamp'     => $this->request['timestamp'],
            'is_pre_ride'   => $preRide
        ]);
    }
}