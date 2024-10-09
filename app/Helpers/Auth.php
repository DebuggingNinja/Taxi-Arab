<?php

use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

if (!function_exists('user_auth')) {
    /**
     * Get the user guard.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function user_auth()
    {
        return Auth::guard('user');
    }
}

if (!function_exists('driver_auth')) {
    /**
     * Get the driver guard.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function driver_auth()
    {
        return Auth::guard('driver');
    }
}
if (!function_exists('driver_token_authenticate')) {

    function driver_token_authenticate($token)
    {
        $token = PersonalAccessToken::findToken($token);

        if (!$token || $token?->tokenable_type != 'App\Models\Driver') return null;

        if ($token->expires_at &&  $expiresAt = Carbon::parse($token->expires_at))
            if ($expiresAt->isPast()) return null;
        $driver = $token->tokenable_type::find($token->tokenable_id);
        if ($driver)
            return $driver;
        return null;
    }
}
if (!function_exists('user_can')) {

    function user_can($permission)
    {
        if (!Auth::user()->can($permission)) abort(403, 'غير مصرح ليك بزيارة هذة الصفحة');
    }
}

if (!function_exists('user_has_permission')) {

    function user_has_permission($permission)
    {
        return Auth::user()->can($permission);
    }
}
