<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HerregSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data mahasiswa dari tabel mahasiswa
        $mahasiswa = DB::table('mahasiswa')->get();

        // Data untuk herreg berdasarkan mahasiswa
        $herregData = [];

        foreach ($mahasiswa as $mhs) {
            $herregData[] = [
                'nim' => $mhs->nim,
                'tahun_ajaran' => '2024/2025', // Tahun ajaran default
                'status' => 1, // Status default aktif
            ];
        }

        // Insert data ke tabel herreg
        DB::table('herreg')->insert($herregData);
    }
}