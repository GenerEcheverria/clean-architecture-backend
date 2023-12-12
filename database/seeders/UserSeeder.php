<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SA',
            "email"=>"albaficas@gmail.com",
            'password' => '$2y$10$Boweq9eXZLCkFRZQrwdgSuhiheVBe6wUZBFy8N7VpEdKWJJdaq16K', //12345678
            "role"=>"Admin",
            "phone"=> "9991732101",
        ]);
        User::create([
            'name' => 'Gener Echeverria',
            "email"=>"gener.echeverria@gmail.com",
            'password' => '$2y$10$Boweq9eXZLCkFRZQrwdgSuhiheVBe6wUZBFy8N7VpEdKWJJdaq16K', //12345678
            "role"=>"Client",
            "phone"=> "9991732101",
        ]);
    }
}
