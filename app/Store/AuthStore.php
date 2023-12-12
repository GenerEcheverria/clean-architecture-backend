<?php
namespace App\Store;

use Core\Interfaces\IAuthStore;

class AuthStore implements IAuthStore
{
    public function login(array $credentials)
    {
        $token = auth()->attempt($credentials);
        return $this->sessionData($token);
    }

    public function getUserData(){
        return response()->json(auth()->user());
    }

    public function destroySesion(){
        auth()->logout();
    }

    public function refreshToken(){
        $tokenRefreshed = auth()->refresh();
        return $this->sessionData($tokenRefreshed);
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