<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
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
        // Check if language is specified in request header, query parameter, or URL path
        $language = $request->header('Accept-Language') ?? $request->query('lang') ?? 'en';
        if ($language == 'ar') $language = 'ar';
        else $language = 'en';
        // Set the application locale
        App::setLocale('ar');

        return $next($request);
    }
}
