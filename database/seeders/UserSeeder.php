<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SA',
            'email' => 'albaficas@gmail.com',
            'password' => '$2y$10$Boweq9eXZLCkFRZQrwdgSuhiheVBe6wUZBFy8N7VpEdKWJJdaq16K', //12345678
            'role' => 'Admin',
            'phone' => '9991732101',
        ]);
        User::create([
            'name' => 'Gener Echeverria',
            'email' => 'gener.echeverria@gmail.com',
            'password' => '$2y$10$Boweq9eXZLCkFRZQrwdgSuhiheVBe6wUZBFy8N7VpEdKWJJdaq16K', //12345678
            'role' => 'Client',
            'phone' => '9991732101',
        ]);
    }
}
