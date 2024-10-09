<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class tempMiddleware
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
        $value = $request->session()->get('logger');

        if ($value == true)
            return $next($request);
        return redirect()->route('dashboard.login')->withErrors('غير مسموح بفتح الصفحة قبل تسجيل الدخول');
    }
}
