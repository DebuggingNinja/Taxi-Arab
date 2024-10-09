<?php

namespace App\Events;

use App\Enums\RideInvitationStatusEnum;
use App\Http\Resources\Locations\LocationResource;
use App\Http\Resources\Users\Invitations\inviteStatusResource;
use App\Models\Location;
use App\Models\RideInvite;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideInviteSentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $ride, $driver, $invite;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ride, $driver, $invite)
    {
        $this->ride     = $ride;
        $this->driver   = $driver;
        $this->invite   = $invite;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('presence.rides.' . $this->ride->id);
    }

    public function broadcastAs()
    {
        return 'ride_invitation_sent';
    }

    public function broadcastWith()
    {
        return (new inviteStatusResource($this->invite))->resolve();
    }
}
