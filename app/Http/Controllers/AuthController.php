<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Store\AuthStore;
use App\Models\User;
use Core\UseCases\Auths;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'checkToken']]);
    }

    public function login(Request $request, AuthStore $authStore)
    {
        $auths = new Auths($authStore);
        $session = $auths->login($request->only(['email', 'password']));

        if ($session == null) {
            return response()->json(['Error' => 'Unauthorized'], 401);
        }

        return $session;
    }

    public function getUserData(AuthStore $authStore) //este nombre va a afectar al endpoint de api.php
    {
        return $authStore->getUserData();
    }

    public function logout(AuthStore $authStore)
    {
        $authStore->destroySesion();
        return response()->json(['response' => 'Successfully logged out'], 200);
    }

    public function refreshToken(AuthStore $authStore) //este nombre va a afectar al endpoint de api.php
    {
        return $authStore->refreshToken();
    }

    public function checkToken(Request $request)
    {
        try {
            $token = JWTAuth::parseToken()->getToken();
            $user = JWTAuth::authenticate($token);
            if (!$user) {
                return response()->json(['valid' => false], 401);
            }
            return response()->json(['valid' => true], 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['valid' => false], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['valid' => false], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['valid' => false], 500);
        }
    }
}
