<?php

namespace App\Events;

use App\Http\Resources\Drivers\Ride\highlightRideInfoCollection;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DriversRealLocationEvent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels,  InteractsWithQueue;

    protected $driver, $location;
    /**
     * Create a new event instance.
     *
     * @return void``
     */
    public function __construct($driver, $location)
    {
        $this->driver = $driver;
        $this->location = $location;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('drivers.real.map');
    }

    public function broadcastWith()
    {
        return ['driver' => $this->driver, 'location' => $this->location];
    }
    public function broadcastAs()
    {
        return 'drivers.real_location';
    }
}
