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
            // NOTES!!!!!!!
            // Mahasiswa role = 1;
            // Akademik role = 2;
            // Dosen Wali role = 3;
            // Kaprodi role = 4;
            // Dekan role = 5;
            // Dekan and Dosen Wali role = 6;
            // Kaprodi and Dosen Wali role = 7;
            // Dosen role = 9;
        $users =[ 
        [
            'name' => 'Muhammad Fikri Firdaus',
            'email' => 'fikrifirdaus2112@gmail.com',
            'password' =>'fikri12345', 
            'role' => '1',
        ],
        [
            'name' => 'Arya Ajisadda Haryanto',
            'email' => 'aryaajisadda@gmail.com',
            'password' =>'arya12345', 
            'role' => '1',
        ],
        [
            'name' => 'Muhammad Daffa Aradhana Adriansyah',
            'email' => 'daffaadrnn@gmail.com',
            'password' =>'daffa12345', 
            'role' => '1',
        ],
        [
            'name' => 'Rizal Adiyanto Nugroho',
            'email' => 'rizaladiyantonugroho@gmail.com',
            'password' =>'rizal12345', 
            'role' => '1',
        ],
        [
            'name' => 'Fajri Nur Iman',
            'email' => 'fajrinur@gmail.com',
            'password' =>'fajri12345', 
            'role' => '6',
        ],
        [
            'name' => 'Syariful Setiawan',
            'email' => 'syariful@gmail.com',
            'password' =>'syariful12345', 
            'role' => '4',
        ],
        [
            'name' => 'Nadhya Kaheitna',
            'email' => 'nadhya@gmail.com',
            'password' =>'nadhya12345', 
            'role' => '3',
        ],
        [
            'name' => 'Benny Rahman Surtanto',
            'email' => 'bennyrahman@gmail.com',
            'password' =>'benny12345', 
            'role' => '2',
        ],
    ];
    foreach ($users as $user) {
        $user['password'] = Hash::make($user['password']);
        User::create($user);
    }
    }
}
