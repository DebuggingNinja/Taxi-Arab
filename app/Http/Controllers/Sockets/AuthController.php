<?php

namespace App\Http\Controllers\Sockets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;

class AuthController extends Controller
{
    public function presence_auth(Request $request)
    {
        //dd('');
        // Instantiate the Pusher object with your credentials
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
        );

        // Example of using authorizePresenceChannel
        $socketId = $request->socket_id;
        $channelName = $request->channel_name;

        return $pusher->authorizePresenceChannel(
            $channelName,
            $socketId,
            user_auth()->id() ?? driver_auth()->id()
        );
    }
}
