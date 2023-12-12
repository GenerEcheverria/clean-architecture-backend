<?php
namespace App\Store;

use Core\Interfaces\IAuthStore;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthStore implements IAuthStore
{
    public function login(array $credentials)
    {
        $token = auth()->attempt($credentials);
        return $this->sessionData($token);
    }

    public function logout(){
        auth()->logout();
    }

    public function refreshToken(){
        $tokenRefreshed = auth()->refresh();
        return $this->sessionData($tokenRefreshed);
    }

    public function checkToken(){
        $token = JWTAuth::parseToken()->getToken();
        return JWTAuth::authenticate($token);
    }

    public function sessionData($token)
    {
        $user = auth()->user();
        $role = $user->role; 

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'role' => $role 
        ]);
    }
}