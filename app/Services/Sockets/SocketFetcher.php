<?php

namespace App\Services\Sockets;

use App\Services\Ride\Driver\RideSearchingService;
use App\Services\Ride\Driver\RideTrackingService;
use Illuminate\Support\Facades\Log;

class SocketFetcher
{
    protected $socketFunctionMap;
    protected $request;

    public function __construct($request)
    {

        $this->request = $request;
        $this->socketFunctionMap = [
            'ride_tracking'             => RideTrackingService::class,
            'driver_location_update'    => RideSearchingService::class,
        ];
    }

    public function socketFunctionHandler()
    {
        $service = $this->getSocketService();
        if ($service !== null) {
            return $service->handleSocketRequest($this->request);
        }

        return null;
    }

    protected function getSocketService()
    {

        if (key_exists($this->request['method'], $this->socketFunctionMap)) {
            return new $this->socketFunctionMap[$this->request['method']]();
        }

        return null;
    }
}
