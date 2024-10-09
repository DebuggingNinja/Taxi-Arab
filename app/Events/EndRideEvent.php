<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EndRideEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected $ride_id, $fare;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride_id, $fare)
    {
        $this->ride_id          = $ride_id;
        $this->fare             = $fare;
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
        return 'end_ride';
    }
    public function broadcastWith()
    {
        return ['fare' => $this->fare];
    }
}
