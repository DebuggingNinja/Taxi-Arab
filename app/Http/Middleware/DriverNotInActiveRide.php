<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DriverNotInActiveRide
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


        if ($this->DriverNotInActiveRideCondtitions())
            return $next($request);
        abort(400, __('app.Unable to proceed: The driver is currently engaged in an active ride'));
    }

    public function DriverNotInActiveRideCondtitions()
    {
        $driver = driver_auth()->user();
        return driver_auth()->check() && $driver->active_ride_id == null;
    }
}
