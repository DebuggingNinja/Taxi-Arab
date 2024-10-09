<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DriverInActiveRide
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->DriverInActiveRideCondtitions())
            return $next($request);
        abort(400, __('app.Unable to proceed: The driver is currently not engaged in an active ride'));
    }

    public function DriverInActiveRideCondtitions()
    {
        $driver = driver_auth()->user();
        return driver_auth()->check() && $driver->active_ride_id != null;
    }
}