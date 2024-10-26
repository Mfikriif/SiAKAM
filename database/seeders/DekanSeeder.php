<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DekanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk tabel dekan
        $dekan = [
            [
                'id'=> '5', // ID yang sama dengan pembimbing akademik
                'nama' => 'Fajri Nur Iman',
                'nip' => '2450045678',
                'email' => 'fajrinur@gmail.com',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-03-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Merdeka No 10, Bandung',
                'no_hp' => '081234222890',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert data ke tabel dekan
        DB::table('dekan')->insert($dekan);
    }
}