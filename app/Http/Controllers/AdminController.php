<?php

namespace App\Http\Controllers;

use App\Store\AdminStore;
use Core\UseCases\Admins;

class AdminController extends Controller
{
    private Admins $admins;
    public function __construct(AdminStore $adminStore)
    {
        $this->middleware('auth:api');
        $this->admins = new Admins($adminStore);
    }
    public function index()
    {
        $adminsList = $this->admins->getAll();
        return response()->json($adminsList, 200);
    }
}
