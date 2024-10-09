<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class TestPusher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pusher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Made for test pusher';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ride = [
            'ride_id' => 0,
            'test' => 'pusher',
        ];
        event(new \App\Events\TestPusherEvent($ride));
        return $ride['ride_id'];
    }
}
