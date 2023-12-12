<?php

namespace App\Http\Controllers;

use App\Store\AdminStore;
use Core\UseCases\Admins;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(AdminStore $AdminStore)
    {
        $admins = new Admins($AdminStore);
        $adminsList = $admins->getAll();
        return response()->json($adminsList, 200);
    }
}
