<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // You can create individual users like this:
        User::create([
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => Hash::make('mahasiswa12345'), // Adjust accordingly, it's hashed
            'mahasiswa' => 1,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 0,
            'akademik' => 0,
        ]);

        User::create([
            'name' => 'dekan',
            'email' => 'dekan@gmail.com',
            'password' => Hash::make('dekan12345'),
            'mahasiswa' => 0,
            'dekan' => 1,
            'kaprodi' => 0,
            'dosenwali' => 0,
            'akademik' => 0,
        ]);

        User::create([
            'name' => 'kaprodi',
            'email' => 'kaprodi@gmail.com',
            'password' => Hash::make('kaprodi12345'),
            'mahasiswa' => 0,
            'dekan' => 0,
            'kaprodi' => 1,
            'dosenwali' => 0,
            'akademik' => 0,
        ]);

        User::create([
            'name' => 'akademik',
            'email' => 'akademik@gmail.com',
            'password' => Hash::make('akademik12345'),
            'mahasiswa' => 0,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 0,
            'akademik' => 1,
        ]);

        User::create([
            'name' => 'dosenwali',
            'email' => 'dosenwali@gmail.com',
            'password' => Hash::make('dosenwali12345'),
            'mahasiswa' => 0,
            'dekan' => 0,
            'kaprodi' => 0,
            'dosenwali' => 1,
            'akademik' => 0,
        ]);

        User::create([
            'name' => 'dosenwali2',
            'email' => 'dosenwali2@gmail.com',
            'password' => Hash::make('dosenwali212345'),
            'mahasiswa' => 0,
            'dekan' => 0,
            'kaprodi' => 1,
            'dosenwali' => 1,
            'akademik' => 0,
        ]);

        User::create([
            'name' => 'dosenwali3',
            'email' => 'dosenwali3@gmail.com',
            'password' => Hash::make('dosenwali312345'),
            'mahasiswa' => 0,
            'dekan' => 1,
            'kaprodi' => 0,
            'dosenwali' => 1,
            'akademik' => 0,
        ]);
    }
}