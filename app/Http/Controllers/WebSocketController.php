<?php

namespace App\Http\Controllers;

use App\Events\RideEvent;
use App\Models\Location;
use App\Services\Sockets\SocketFetcher;
use BeyondCode\LaravelWebSockets\Facades\StatisticsLogger;
use BeyondCode\LaravelWebSockets\Server\Logger\HttpLogger;
use BeyondCode\LaravelWebSockets\WebSockets\Messages\PusherMessageFactory;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler;
use Illuminate\Support\Facades\Log;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class WebSocketController extends WebSocketHandler
{
    public function onMessage(ConnectionInterface $connection, MessageInterface $message)
    {
        $jsonMessage = json_decode($message->getPayload(), true);
        Log::info('Start Recive Event');
        Log::info($jsonMessage);
        if ($jsonMessage['event'] == "pusher:send") {
            Log::info('inside Pusher:send');
            $socketFetcher = new SocketFetcher($jsonMessage);
            return $socketFetcher->socketFunctionHandler();
        } else {
            $message = PusherMessageFactory::createForMessage($message, $connection, $this->channelManager);
            $message->respond();
            StatisticsLogger::webSocketMessage($connection);
        }
    }
}
