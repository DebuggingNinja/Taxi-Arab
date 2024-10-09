<?php

namespace App\Listeners;

use App\Events\RideInviteEvent;
use App\Events\RideInviteSentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RideInviteEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RideInviteEvent $event)
    {
        broadcast(new RideInviteSentEvent($event->ride, $event->driver, $event->invite));
    }
}
