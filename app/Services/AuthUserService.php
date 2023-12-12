<?php

namespace App\Services;

use Core\Interfaces\IAuthUser;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthUserService implements IAuthUser
{
    public function authenticate()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}
