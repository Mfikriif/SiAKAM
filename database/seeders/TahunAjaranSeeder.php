<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $startYear = 2015;
        $endYear = 2024;

        for ($year = $startYear; $year <= $endYear; $year++) {
            $nextYear = $year + 1;

            // Tambahkan data untuk semester Ganjil
            $data[] = [
                'tahun' => "{$year}/{$nextYear}",
                'semester' => 'Ganjil',
                'is_active' => ($year === 2024 && $nextYear === 2025), // Aktif hanya untuk 2024/2025 Ganjil
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Tambahkan data untuk semester Genap
            $data[] = [
                'tahun' => "{$year}/{$nextYear}",
                'semester' => 'Genap',
                'is_active' => false, // Semua semester Genap tidak aktif
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan data ke tabel
        DB::table('tahun_ajaran')->insert($data);
    }
}