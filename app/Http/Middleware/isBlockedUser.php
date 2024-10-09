<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isBlockedUser
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
        if (!$this->isBlockedUser())
            return $next($request);
        abort(400, __('app.Access has been restricted due to a violation of the rules, and you are now blocked'));
    }

    public function isBlockedUser()
    {
        $User = user_auth()->user();
        return user_auth()->check() && $User->is_blocked == 1;
    }
}
