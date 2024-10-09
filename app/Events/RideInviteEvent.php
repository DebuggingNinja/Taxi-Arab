<?php

namespace App\Events;

use App\Http\Resources\Drivers\Ride\highlightRideInfoResource;
use App\Http\Resources\Users\Invitations\inviteStatusResource;
use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RideInviteEvent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithQueue;

    public $ride, $driver, $invite;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride, $driver, $invite)
    {
        $this->ride      = $ride;
        $this->driver    = $driver;
        $this->invite    = $invite;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('private.driver.' . $this->driver->id . '.rides.search'); // Search Channel

    }

    public function broadcastAs()
    {
        return 'ride_invitation';
    }

    public function broadcastWith()
    {
        return [
            'invite_information' => new inviteStatusResource($this->invite),
            'ride_information'  => new highlightRideInfoResource($this->ride),
        ];
    }
}
