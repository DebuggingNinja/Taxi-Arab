<?php

use App\Broadcasting\RideChannel;
use App\Broadcasting\RideSearchChannel;
use App\Broadcasting\RidesMapChannel;
use App\Http\Controllers\API\User\Ride\RideController;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('presence.rides.{ride}', RideChannel::class, ['guards' => ['user', 'driver']]);
Broadcast::channel('private.driver.{driverId}.rides.search', RideSearchChannel::class, ['guards' => ['driver']]);
Broadcast::channel('drivers.real.map', RidesMapChannel::class,  ['guards' => ['user']]);
