<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Store\RealClientStore;
use Core\UseCases\RegisterClient;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register']]);
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    public function register(Request $request, RealClientStore $realClientStore)
    {
        try {
            $registerClient = new RegisterClient($realClientStore);
            $user = $registerClient->execute($request->all());
            return response()->json([
                'message' => 'Successfully created',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User Registration Failed!',
                'error' => $e->getMessage()
            ], 409);
        }
    }

    /**
     * Display the specified user.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        if (User::where("id", $id)->exists()) {
            $user = User::find($id);
            // $user->fill($request->only([
            //     'user.name',
            //     'user.email',
            //     'user.phone'
            // ]));
            if ($request->has('cuenta.nombre')) {
                $user->name =  $request->input('cuenta.nombre');
                $user->email =  $request->input('cuenta.email');
                $user->phone =  $request->input('cuenta.tel');
            }

            if ($request->has('cuenta.cpass')) {
                $user->password = bcrypt($request->input('cuenta.cpass'));
            }
            $pass = $request->input('cuenta.cpass');

            $user->save();

            return response()->json([
                "message" => "User updated successfully",
                'user' => $user,
                'newpassword' => $pass
            ], 200);
        } else {
            return response()->json([
                "error" => "User not found",
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                "message" => "User deleted successfully",
            ], 202);
        } else {
            return response()->json([
                "error" => "User not found",
            ], 404);
        }
    }

    /**
     * Get SA users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSaUsers(Request $request)
    {
        $users = User::select('id', 'name')
            ->where('role', 'admin')
            ->get();
        return response()->json($users, 200);
    }


    /**
     * Get sites for a specific user.
     *
     * @param  string  $userId
     * @return \Illuminate\Http\JsonResponse
     */


    public function getSitesForUser($userId)
    {
        $user = User::findOrFail($userId);
        $sites = $user->sites;

        return response()->json([
            'sites' => $sites
        ], 200);
    }

    /**
     * Get the number of sites for a specific user.
     *
     * @param  string  $userId
     * @return int
     */
    public function getnumSitesForUser($userId)
    {
        $user = User::findOrFail($userId);
        $siteCount = $user->sites()->count();

        return $siteCount;
    }
}
