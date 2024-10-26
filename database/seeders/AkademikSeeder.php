<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk tabel akademik
        $akademik = [
            [
                'id'=> '8',
                'nama' => 'Benny Rahman Surtanto',
                'nip' => '2450012345',
                'email' => 'bennyrahman@gmail.com',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1985-07-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Merdeka No 10, Jakarta',
                'no_hp' => '081234567890',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert data ke tabel akademik
        DB::table('akademik')->insert($akademik);
    }
}