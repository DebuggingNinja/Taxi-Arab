<?php

namespace App\Broadcasting;

use App\Events\RideEvent;
use App\Models\Driver;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RideChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function join(User|Driver $user, Ride $ride)
    {

        if (!$ride || !$ride->matchDriverOrUser($user->id))
            return false;

        return $user->id;
    }

    /**
     * Listen for broadcast events.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ride  $ride
     * @param  array  $data
     * @return array|bool
     */
    public function listen(User|Driver $user, Ride $ride, array $data)
    {
        Log::info('Listen Triggered');
        // Handle the incoming WebSocket message
        $action = $data['action'];
        dd($action);
        switch ($action) {
            case 'ping':
                // Handle the 'ping' action
                // Respond with a 'pong' message
                $this->sendPong($user, $ride);
                break;

                // Add more cases as needed for different actions

            default:
                // Unknown action
                break;
        }
    }

    /**
     * Send a 'pong' message in response to a 'ping'.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ride  $ride
     * @return void
     */
    protected function sendPong(User $user, Ride $ride)
    {
        Log::info('Event Triggered');

        // Prepare the 'pong' message
        $pongMessage = [
            'type' => 'pong',
            // You can include additional data in the 'pong' response if needed
        ];

        // Broadcast the 'pong' message to the user on the ride channel
        broadcast(new RideEvent($ride, $pongMessage))->toOthers();
    }
}
