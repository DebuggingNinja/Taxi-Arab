<?php

namespace App\Events;

use App\Http\Resources\Drivers\DriverResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideAcceptedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected $ride_id, $driver;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride_id, $driver)
    {
        $this->ride_id          = $ride_id;
        $this->driver           = $driver;
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
        return 'ride_accepted';
    }

    public function broadcastWith()
    {
        return (new DriverResource($this->driver))->resolve();
    }
}
