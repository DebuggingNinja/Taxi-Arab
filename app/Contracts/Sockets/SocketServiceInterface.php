<?php

namespace App\Contracts\Sockets;

interface SocketServiceInterface
{
    public function handleSocketRequest($request);
}