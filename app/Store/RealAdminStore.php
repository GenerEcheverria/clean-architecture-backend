<?php
namespace App\Store;

use App\Models\User;
use Core\Interfaces\AdminStore;

class RealAdminStore implements AdminStore
{
    public function getAll()
    {
        $admins = User::select('id', 'name')
            ->where('role', 'Admin')
            ->get();
        return $admins;
    }
}