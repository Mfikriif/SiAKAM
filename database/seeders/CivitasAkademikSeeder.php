<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CivitasAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data for civitas_akademik table
        $civitas_akademik = [
            [
                'id' => 5,
                'nama' => 'Fajri Nur Iman',
                'nip' => '2450045678',
                'email' => 'fajrinur@gmail.com',
                'jurusan' => 'Informatika',
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
                'id' => 6,
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
            ],
            [
                'id' => 7,
                'nama' => 'Nadhya Kaheitna',
                'nip' => '2450023456',
                'email' => 'nadhya@gmail.com',
                'jurusan' => 'Kimia',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1965-07-10',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jalan Sumetra No 11, Jakarta',
                'no_hp' => '08213424242',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'nama' => 'Benny Rahman Surtanto',
                'nip' => '2450012345',
                'email' => 'bennyrahman@gmail.com',
                'jurusan' => null,
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1985-07-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Merdeka No 10, Jakarta',
                'no_hp' => '081234567890',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'nama' => 'Wiradrana Genuk',
                'nip' => '2450042345',
                'email' => 'wira@gmail.com',
                'jurusan' => 'Informatika',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1995-01-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Merdeka No 10, Semarang',
                'no_hp' => '08122233234',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'nama' => 'Budi Setiawan',
                'nip' => '2450222345',
                'email' => 'budi@gmail.com',
                'jurusan' => 'Bioteknologi',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2000-05-18',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Budi Utomo No 10, Semarang',
                'no_hp' => '081222999',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data into civitas_akademik table
        DB::table('civitas_akademik')->insert($civitas_akademik);
    }
}