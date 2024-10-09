<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserNotInActiveRide
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


        if ($this->UserNotInActiveRideCondtitions())
            return $next($request);
        abort(400, __('app.Unable to proceed: The User is currently engaged in an active ride'));
    }

    public function UserNotInActiveRideCondtitions()
    {
        $user = user_auth()->user();
        return user_auth()->check() && $user->active_ride_id == null;
    }
}