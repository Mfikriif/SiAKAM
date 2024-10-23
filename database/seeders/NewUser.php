<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Muhammad Fikri Firdaus',
            'email' => 'fikrifirdaus2112@gmail.com',
            'password' => Hash::make('fikri12345'), 
        ],
        [
            'name' => 'Muhammad Fikri Firdaus',
            'email' => 'fikrifirdaus2112@gmail.com',
            'password' => Hash::make('fikri12345'), 
        ],
        
        );
    }
}
