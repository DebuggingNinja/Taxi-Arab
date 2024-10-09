<?php

namespace App\Events;

use App\Http\Resources\Ride\RideTrackingResource;
use App\Models\RideTracking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RideTrackingEvent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels,  InteractsWithQueue;

    protected $ride_id, $rideTracking;
    /**
     * Create a new event instance.
     *
     * @return void``
     */
    public function __construct($rideTracking)
    {
        $this->ride_id = $rideTracking->ride_id;
        $this->rideTracking = $rideTracking;
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

    public function broadcastWith()
    {
        return (new RideTrackingResource($this->rideTracking))->resolve();
    }
}
