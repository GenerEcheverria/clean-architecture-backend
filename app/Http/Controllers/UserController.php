<?php

namespace App\Http\Controllers;

use App\Store\UserStore;
use Core\UseCases\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private Users $users;

    public function __construct(UserStore $userStore)
    {
        $this->middleware('auth:api', ['except' => ['register']]);
        $this->users = new Users($userStore);
    }

    public function index()
    {
        return $this->users->getAll();
    }

    public function register(Request $request)
    {
        try {
            $registeredUser = $this->users->register($request->all());

            return response()->json([
                'message' => 'Successfully created',
                'user' => $registeredUser,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User Registration Failed!',
                'error' => $e->getMessage(),
            ], 409);
        }
    }

    public function show(string $id)
    {
        return $this->users->getById($id);
    }

    public function update(Request $request, string $id)
    {
        try {
            $this->users->update($request->all(), $id);

            return response()->json([
                'message' => 'User updated successfully',
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'error' => 'User not found out',
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        if ($this->users->delete($id)) {
            return response()->json([
                'message' => 'User deleted successfully',
            ], 202);
        } else {
            return response()->json([
                'error' => 'User not found',
            ], 404);
        }
    }

    public function getUserData()
    {
        return $this->users->getUserData();
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
