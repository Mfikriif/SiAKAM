<?php

namespace Database\Seeders;

use App\Models\User;
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
        
        $users = [
            [
                'id' => 1,
                'name' => 'Muhammad Fikri Firdaus',
                'email' => 'fikrifirdaus2112@gmail.com',
                'password' => 'fikri12345',
                'role' => '1',
                'profile_photo' => 'images/profiles/fikri.jpg',
            ],
            [
                'id' => 2,
                'name' => 'Arya Ajisadda Haryanto',
                'email' => 'aryaajisadda@gmail.com',
                'password' => 'arya12345',
                'role' => '1',
                'profile_photo' => 'images/profiles/arya.jpg',
            ],
            [
                'id' => 3,
                'name' => 'Muhammad Daffa Aradhana Adriansyah',
                'email' => 'daffaadrnn@gmail.com',
                'password' => 'daffa12345',
                'role' => '1',
                'profile_photo' => 'images/profiles/daffa.jpg',
            ],
            [
                'id' => 4,
                'name' => 'Rizal Adiyanto Nugroho',
                'email' => 'rizaladiyantonugroho@gmail.com',
                'password' => 'rizal12345',
                'role' => '1',
                'profile_photo' => 'images/profiles/rizal.jpg',
            ],
            [
                'id' => 5,
                'name' => 'Fajri Nur Iman',
                'email' => 'fajrinur@gmail.com',
                'password' => 'fajri12345',
                'role' => '6',
                'profile_photo' => 'images/profiles/fajri.jpg',
            ],
            [
                'id' => 6,
                'name' => 'Syariful Setiawan',
                'email' => 'syariful@gmail.com',
                'password' => 'syariful12345',
                'role' => '4',
                'profile_photo' => 'images/profiles/syariful.jpg',
            ],
            [
                'id' => 7,
                'name' => 'Nadhya Kaheitna',
                'email' => 'nadhya@gmail.com',
                'password' => 'nadhya12345',
                'role' => '3',
                'profile_photo' => 'images/profiles/nadhya.jpg',
            ],
            [
                'id' => 8,
                'name' => 'Benny Rahman Surtanto',
                'email' => 'bennyrahman@gmail.com',
                'password' => 'benny12345',
                'role' => '2',
                'profile_photo' => 'images/profiles/benny.jpg',
            ],
            [
                'id' => 9,
                'name' => 'Wiradrana Genuk',
                'email' => 'wira@gmail.com',
                'password' => 'wira12345',
                'role' => '3',
                'profile_photo' => 'images/profiles/wira.jpg',
            ],
            [
                'id' => 10,
                'name' => 'Budi Setiawan',
                'email' => 'budi@gmail.com',
                'password' => 'budi12345',
                'role' => '4',
                'profile_photo' => 'images/profiles/budi.jpg',
            ],
            [
                'id' => 11,
                'name' => 'Tasrari Qolbi Nur Kholis',
                'email' => 'tasrari@gmail.com',
                'password' => 'tasrari12345',
                'role' => '1',
                'profile_photo' => 'images/profiles/tasrari.jpg',
            ],
            [
                'id' => 12,
                'name' => 'Revanda Putri Andita',
                'email' => 'revanda@gmail.com',
                'password' => 'revanda12345',
                'role' => '1',
                'profile_photo' => 'images/profiles/revanda.jpg',
            ],
        ];
        foreach ($users as $user) {
            $user['password'] = Hash::make($user['password']);
            User::create($user);
        }
    }
}