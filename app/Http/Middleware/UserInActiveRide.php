<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserInActiveRide
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
        if ($this->UserInActiveRideCondtitions())
            return $next($request);
        abort(400, __('app.Unable to proceed: The User is currently engaged in an active ride'));
    }

    public function UserInActiveRideCondtitions()
    {
        $User = user_auth()->user();
        return user_auth()->check() && $User->active_ride_id != null;
    }
}
