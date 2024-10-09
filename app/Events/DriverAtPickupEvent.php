<?php

namespace App\Events;

use App\Http\Resources\Drivers\DriverResource;
use App\Http\Resources\Locations\LocationResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverAtPickupEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected $ride_id, $location;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride_id, $location)
    {
        $this->ride_id          = $ride_id;
        $this->location         = $location;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('presence.rides.' . $this->ride_id);
    }

    public function broadcastAs()
    {
        return 'driver_at_pickup';
    }

    public function broadcastWith()
    {
        return (new LocationResource($this->location))->resolve();
    }
}
