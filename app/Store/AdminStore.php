<?php

namespace App\Store;

use App\Models\User;
use Core\Interfaces\IAdminStore;

class AdminStore implements IAdminStore
{
    public function getAll()
    {
        $admins = User::select('id', 'name')
            ->where('role', 'Client')
            ->get();

        return $admins;
    }
}
