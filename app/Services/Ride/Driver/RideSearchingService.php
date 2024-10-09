<?php

namespace App\Services\Ride\Driver;

use App\Contracts\Sockets\SocketServiceInterface;
use App\Enums\RideStatusEnum;
use App\Events\AvailableRidesEvent;
use App\Events\RideTrackingEvent;
use App\Helpers\ArrayValidator;
use App\Http\Resources\Drivers\Ride\highlightRideInfoCollection;
use App\Models\Driver;
use App\Models\Location;
use App\Models\Ride;
use App\Models\RideTracking;
use App\Services\LocationService;
use Illuminate\Support\Facades\Log;
use App\Events\DriversRealLocationEvent;

/**
 * Class SocketDataFetcher
 *
 */
class RideSearchingService implements SocketServiceInterface
{
    protected $request, $driver;
    public function handleSocketRequest($request)
    {
        $this->request = $request['data'];
        $this->rideSearchHandler();
    }
    public function auth()
    {
        $driver = driver_token_authenticate($this->request['bearer']);
        $authorizedToAccess = $driver &&
            $driver->is_verified &&
            $driver->accepting_rides &&
            !$driver->is_blocked;
        $this->driver = $authorizedToAccess ? $driver : null;
    }
    public function requestValidator()
    {
        if (!$this->request) return false;
        $rules = [
            'latitude'      => ['required', 'numeric'],
            'longitude'     => ['required', 'numeric'],
        ];
        $valid = ArrayValidator::valid($this->request, $rules);
        if ($valid)
            return true;
        return false;
    }
    public function rideSearchHandler()
    {
        $this->auth();
        if ($this->driver && $this->requestValidator()){
            $this->driver->update([
                'latest_location_id' => LocationService::locate($this->request['latitude'], $this->request['longitude'])
            ]);
            broadcast(new DriversRealLocationEvent($this->driver, [
                "latitude" => $this->request['latitude'],
                "longitude" => $this->request['longitude']
            ]));
        }
    }
}
