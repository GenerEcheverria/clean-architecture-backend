<?php
namespace App\Store;

use Core\Entities\UserDTO;
use App\Models\User;
use Core\Interfaces\UserStore;

class RealUserStore implements UserStore
{
    public function getAll()
    {
        return User::all();
    }
    public function save(UserDTO $client): void
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

    public function getById(int $id): User
    {
        return User::find($id);
    }

    public function isUserStored(int $id): bool
    {
        return User::where('id', $id)->exists();
    }

    public function update(UserDTO $client, $id) {
        $user = User::find($id);
        $user->name = $client->name;
        $user->email = $client->email;
        $user->password = $client->password;
        $user->phone = $client->phone;
        $user->save();
    }
}
