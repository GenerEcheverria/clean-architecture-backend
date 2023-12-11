<?php
namespace App\Store;

use Core\Interfaces\ClientStore;
use Core\Entities\ClientDTO;
use App\Models\User;

class RealClientStore implements ClientStore
{
    public function save(ClientDTO $client): void
    {
        $userAttributes = [
            'name' => $client->name,
            'email' => $client->email,
            'password' => $client->password,
            'role' => $client->role,
            'phone' => $client->phone,
        ];

        User::create($userAttributes);
    }
}
