<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store\AuthStore;
use Core\UseCases\Auths;

class AuthController extends Controller
{
    private Auths $auths;

    public function __construct(AuthStore $authStore)
    {
        $this->middleware('auth:api', ['except' => ['login', 'checkToken']]);
        $this->auths = new Auths($authStore);
    }

    public function login(Request $request)
    {
        $session = $this->auths->login($request->only(['email', 'password']));

        if ($session == null) {
            return response()->json(['Error' => 'Unauthorized'], 401);
        }

        return $session;
    }

    public function refreshToken()
    {
        return $this->auths->refreshToken();
    }

    public function checkToken(Request $request)
    {
        try {
            $user = $this->auths->checkToken();
            
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

    public function logout()
    {
        $this->auths->logout();
        return response()->json(['response' => 'Successfully logged out'], 200);
    }
}