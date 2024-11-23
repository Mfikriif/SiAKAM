<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhsMahasiswa extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('khs')->insert([
            ['nim' => '24060122140115','nama' => 'Muhammad Fikri Firdau', 'program_studi' => 'informatika', 'semester' => 4, 'kode_mk' => 'PAIK6404', 'nama_mk' => 'Grafika dan Komputasi Visual', 'sks' => 3,'nilai_angka' => 90, 'nilai_huruf' => 'A'],
            ['nim' => '24060122140115','nama' => 'Muhammad Fikri Firdau', 'program_studi' => 'informatika', 'semester' => 4, 'kode_mk' => 'PAIK6401', 'nama_mk' => 'Pemrograman Berbasis Objek', 'sks' => 3,'nilai_angka' => 85, 'nilai_huruf' => 'A'],
            ['nim' => '24060122140115','nama' => 'Muhammad Fikri Firdau', 'program_studi' => 'informatika', 'semester' => 4, 'kode_mk' => 'PAIK6406', 'nama_mk' => 'Sistem Cerda', 'sks' => 3,'nilai_angka' => 75, 'nilai_huruf' => 'B'],
            ['nim' => '24060122140115','nama' => 'Muhammad Fikri Firdau', 'program_studi' => 'informatika', 'semester' => 4, 'kode_mk' => 'PAIK6403', 'nama_mk' => 'Manajemen Basis Data', 'sks' => 3,'nilai_angka' => 80, 'nilai_huruf' => 'B'],
            ['nim' => '24060122140115','nama' => 'Muhammad Fikri Firdau', 'program_studi' => 'informatika', 'semester' => 4, 'kode_mk' => 'PAIK6405', 'nama_mk' => 'Rekayasa Perangkat Lunak', 'sks' => 3,'nilai_angka' => 92, 'nilai_huruf' => 'A'],
            ['nim' => '24060122140115','nama' => 'Muhammad Fikri Firdau', 'program_studi' => 'informatika', 'semester' => 4, 'kode_mk' => 'PAIK6601', 'nama_mk' => 'Analisis dan Strategi Algoritma', 'sks' => 3,'nilai_angka' => 70, 'nilai_huruf' => 'B'],
        ]);
    }
}
