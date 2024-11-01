<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaprodiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk tabel kaprodi
        $kaprodi = [
            [
                'id'=> '6',
                'nama' => 'Syariful Setiawan',
                'nip' => '2450034567',
                'email' => 'syariful@gmail.com',
                'jurusan' => 'Informatika',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1935-07-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Kalibanteng No 11, Jakarta',
                'no_hp' => '0821342221142',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert data ke tabel kaprodi
        DB::table('kaprodi')->insert($kaprodi);
    }
}