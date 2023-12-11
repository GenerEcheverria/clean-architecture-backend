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
            'password' => '$2y$10$06bfQ6iUQeaZn6v1jPFfBexFI3nT1AC94oktN6BAIlr4t7x5jteJq',
            "role"=>"Admin",
            "phone"=> "9991732101",
        ]);
        User::create([
            'name' => 'Gener Echeverria',
            "email"=>"gener.echeverria@gmail.com",
            'password' => '$2y$10$06bfQ6iUQeaZn6v1jPFfBexFI3nT1AC94oktN6BAIlr4t7x5jteJq',
            "role"=>"Client",
            "phone"=> "9991732101",
        ]);
    }
}
