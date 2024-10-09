<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isActiveUser
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
        if ($this->ActiveUser())
            return $next($request);
        abort(400, __('app.Unable to proceed: Your account is currently not verified'));
    }

    public function ActiveUser()
    {
        $User = user_auth()->user();
        return user_auth()->check() && $User->is_verified == 1;
    }
}