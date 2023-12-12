<?php

namespace App\Http\Controllers;

use App\Store\RealAdminStore;
use Core\UseCases\Admins;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(RealAdminStore $realAdminStore)
    {
        $admins = new Admins($realAdminStore);
        $adminsList = $admins->getAll();
        return response()->json($adminsList, 200);
    }
}
