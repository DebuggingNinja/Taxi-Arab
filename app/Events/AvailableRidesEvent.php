<?php

namespace App\Events;

use App\Http\Resources\Drivers\Ride\highlightRideInfoCollection;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AvailableRidesEvent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels,  InteractsWithQueue;

    protected $availableRides, $driverId;
    /**
     * Create a new event instance.
     *
     * @return void``
     */
    public function __construct($availableRides, $driverId)
    {
        $this->driverId         = $driverId;
        $this->availableRides   = $availableRides;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('private.driver.' . $this->driverId . '.rides.search');
    }

    public function broadcastWith()
    {
        return (new highlightRideInfoCollection($this->availableRides))->resolve();
    }
    public function broadcastAs()
    {
        return 'ride.search';
    }
}
