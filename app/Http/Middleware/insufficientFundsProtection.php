<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class insufficientFundsProtection
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

        if ($this->isDriverWithNoFunds())
            abort(400, __('app.Unable to proceed: Your account balance is insufficient to perform this action'));
        return $next($request);
    }

    public function isDriverWithNoFunds()
    {
        $driver = driver_auth()->user();
        return driver_auth()->check() && $driver->current_credit_amount <= (getSetting('MINIMUM_CREDIT_TO_ACCEPT_RIDE') ?? 0);
    }
}
