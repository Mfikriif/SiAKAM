<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk tabel mahasiswa
        $mahasiswa = [
            [
                'id' => 1,
                'nama' => 'Muhammad Fikri Firdaus',
                'nim' => '24060122140115',
                'email' => 'fikrifirdaus2112@gmail.com',
                'semester' => 5,
                'jurusan' => 'S1 Informatika',
                'tempat_lahir' => 'Bekasi',
                'tanggal_lahir' => '2003-12-21',
                'jenis_kelamin' => 'L',
                'alamat' => 'Perumahan Bumi Mutiara Blok Ji 2 No 8 Gunung Putri Bogor',
                'no_hp' => '087870805235',
                'angkatan' => 2022,
                'status' => 1,
                'pembimbing_akademik_id' => 5,
            ],
            [
                'id' => 2,
                'nama' => 'Arya Ajisadda Haryanto',
                'nim' => '24060122140118',
                'email' => 'aryaajisadda@gmail.com',
                'semester' => 5,
                'jurusan' => 'S1 Informatika',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2004-05-14',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Tlogo Timun 1, Semarang',
                'no_hp' => '08112786860',
                'angkatan' => 2022,
                'status' => 1,
                'pembimbing_akademik_id' => 5,
            ],
            [
                'id' => 3,
                'nama' => 'Muhammad Daffa Aradhana Adriansyah',
                'nim' => '24060122120022',
                'email' => 'daffaadrnn@gmail.com',
                'semester' => 5,
                'jurusan' => 'S1 Informatika',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2004-03-30',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Kanfer Raya 5, Semarang',
                'no_hp' => '082138288712',
                'angkatan' => 2022,
                'status' => 1,
                'pembimbing_akademik_id' => 5,
            ],
            [
                'id' => 4,
                'nama' => 'Rizal Adiyanto Nugroho',
                'nim' => '24060122140156',
                'email' => 'rizaladiyantonugroho@gmail.com',
                'semester' => 5,
                'jurusan' => 'S1 Informatika',
                'tempat_lahir' => 'Pemalang',
                'tanggal_lahir' => '2004-11-20',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jalan Sulawesi 48, Pemalang',
                'no_hp' => '082314755575',
                'angkatan' => 2022,
                'status' => 1,
                'pembimbing_akademik_id' => 5,
            ],
            [
                'id' => 11,
                'nama' => 'Tasrari Qolbi Nur Kholis',
                'nim' => '24020222130090',
                'email' => 'tasrari@gmail.com',
                'semester' => 5,
                'jurusan' => 'S1 Bioteknologi',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2004-09-24',
                'jenis_kelamin' => 'L',
                'alamat' => 'Sumurbroto, Semarang',
                'no_hp' => '08112712818',
                'angkatan' => 2022,
                'status' => 1,
                'pembimbing_akademik_id' => 7,
            ],
        ];

        // Insert data ke tabel mahasiswa
        DB::table('mahasiswa')->insert($mahasiswa);
    }
}