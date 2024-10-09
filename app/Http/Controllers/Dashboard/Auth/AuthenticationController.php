<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Login\LoginRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function dashboardLogin()
    {
        return view('dashboard.auth.login');
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('home');
        }

        return redirect()->route('dashboard.login')->withErrors('اسم المستخدم او كلمة المرور غير صحيحة');
    }

    public function dashboardLogout(request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('dashboard.login');
    }
}
