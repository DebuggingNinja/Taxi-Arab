<?php

namespace App\Http\Controllers\API\User\Auth;

use App\Repository\AuthControllerRepository;
use App\Models\User;

class AuthController extends AuthControllerRepository
{
    function __construct()
    {
        $this->authModel = User::class;
    }
}