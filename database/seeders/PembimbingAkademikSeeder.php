<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembimbingAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk tabel pembimbing_akademik
        $pembimbingAkademik = [
            [
                'id'=> '5',
                'nama' => 'Fajri Nur Iman',
                'nip' => '2450045678',
                'email' => 'fajrinur@gmail.com',
                'jurusan' => 'S1 Informatika',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-03-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Merdeka No 10, Bandung',
                'no_hp' => '081234222890',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'=> '7',
                'nama' => 'Nadhya Kaheitna',
                'nip' => '2450023456',
                'email' => 'nadhya@gmail.com',
                'jurusan' => 'S1 Kimia',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1965-07-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Sumetra No 11, Jakarta',
                'no_hp' => '08213424242',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data ke tabel pembimbing_akademik
        DB::table('pembimbing_akademik')->insert($pembimbingAkademik);
    }
}