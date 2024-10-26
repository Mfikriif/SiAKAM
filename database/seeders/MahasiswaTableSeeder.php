<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            'id' => 1,
            'nama'=> 'Muhammad Fikri Firdaus',
            'nim' => '24060122140115',
            'email' => 'fikrifirdaus2112@gmail.com',
            'jurusan' => 'S1 Teknik Informatika',
            'angkatan'=> 2022,
            'tempat_lahir' => 'Bekasi',
            'alamat' => 'Bumi Mutiara Blok Ji 2 No 8 Gunung Putri Bogor',
            'no_hp' => '087870805235',
            'status' => 1,
        ]);
    }
}
