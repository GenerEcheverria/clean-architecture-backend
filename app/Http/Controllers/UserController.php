<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store\UserStore;
use Core\UseCases\Users;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register']]);
    }

    public function index(UserStore $UserStore)
    {
        $users = new Users($UserStore);
        return $users->getAll();
    }

    public function register(Request $request, UserStore $UserStore)
    {
        try {
            $users = new Users($UserStore);
            $registeredUser = $users->register($request->all());
            return response()->json([
                'message' => 'Successfully created',
                'user' => $registeredUser
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User Registration Failed!',
                'error' => $e->getMessage()
            ], 409);
        }
    }
    public function show(string $id, UserStore $UserStore)
    {
        $users = new Users($UserStore);
        return $users->getById($id);
    }

    public function update(Request $request, string $id, UserStore $UserStore)
    {
        try {
            $users = new Users($UserStore);
            $users->update($request->all(), $id);
            return response()->json([
                "message" => "User updated successfully",
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                "error" => "User not found out",
            ], 404);
        }
    }

    public function destroy(string $id,UserStore $UserStore)
    {
        $users = new Users($UserStore);
        if ($users->delete($id)) {
            return response()->json([
                "message" => "User deleted successfully",
            ], 202);
        } else {
            return response()->json([
                "error" => "User not found",
            ], 404);
        }
    }


   //PARECE QUE NO SE USAN

    // public function getSitesForUser($userId)
    // {
    //     $user = User::findOrFail($userId);
    //     $sites = $user->sites;

    //     return response()->json([
    //         'sites' => $sites
    //     ], 200);
    // }

    // /**
    //  * Get the number of sites for a specific user.
    //  *
    //  * @param  string  $userId
    //  * @return int
    //  */
    // public function getnumSitesForUser($userId)
    // {
    //     $user = User::findOrFail($userId);
    //     $siteCount = $user->sites()->count();

    //     return $siteCount;
    // }
}
