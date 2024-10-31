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
        $users =[ 
        [
            'name' => 'Muhammad Fikri Firdaus',
            'email' => 'fikrifirdaus2112@gmail.com',
            'password' =>'fikri12345', 
            'mahasiswa' => 1,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 0,
            'akademik' => 0,
        ],
        [
            'name' => 'Arya Ajisadda Haryanto',
            'email' => 'aryaajisadda@gmail.com',
            'password' =>'arya12345', 
            'mahasiswa' => 1,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 0,
            'akademik' => 0,
        ],
        [
            'name' => 'Muhammad Daffa Aradhana Adriansyah',
            'email' => 'daffaadrnn@gmail.com',
            'password' =>'daffa12345', 
            'mahasiswa' => 1,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 0,
            'akademik' => 0,
        ],
        [
            'name' => 'Rizal Adiyanto Nugroho',
            'email' => 'rizaladiyantonugroho@gmail.com',
            'password' =>'rizal12345', 
            'mahasiswa' => 1,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 0,
            'akademik' => 0,
        ],
        [
            'name' => 'Fajri Nur Iman',
            'email' => 'fajrinur@gmail.com',
            'password' =>'fajri12345', 
            'mahasiswa' => 0,
            'dekan' => 1,
            'kaprodi' => 0,
            'dosenwali' => 1,
            'akademik' => 0,
        ],
        [
            'name' => 'Syariful Setiawan',
            'email' => 'syariful@gmail.com',
            'password' =>'syariful12345', 
            'mahasiswa' => 0,
            'dekan' => 0,
            'kaprodi' => 1,
            'dosenwali' => 0,
            'akademik' => 0,
        ],
        [
            'name' => 'Nadhya Kaheitna',
            'email' => 'nadhya@gmail.com',
            'password' =>'nadhya12345', 
            'mahasiswa' => 0,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 1,
            'akademik' => 0,
        ],
        [
            'name' => 'Benny Rahman Surtanto',
            'email' => 'bennyrahman@gmail.com',
            'password' =>'benny12345', 
            'mahasiswa' => 0,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 0,
            'akademik' => 1,
        ],
    ];
    foreach ($users as $user) {
        $user['password'] = Hash::make($user['password']);
        User::create($user);
    }
    }
}
