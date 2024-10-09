<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected $ride_id, $test;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride_id)
    {
        $this->ride_id          = $ride_id;
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
        return 'ride';
    }

    public function broadcastWith()
    {
        if ($this->test)
            return $this->test;
    }
}
