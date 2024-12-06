<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy IRS
        $irsData = [
            [
                'irs_id' => 1,
                'mahasiswa_id' => 2, // ID mahasiswa dengan NIM 24060122140118
                'nim' => '24060122140118',
                'nama' => 'Arya Ajisadda Haryanto',
                'program_studi' => 'S1 Informatika',
                'semester' => 5,
                'tahun_akademik' => '2024/2025',
                'kode_mk' => 'IF401',
                'nama_mk' => 'Pemrograman Web Lanjut',
                'kelas' => 'A',
                'sks' => 3,
                'status' => 0, // 0 = belum disetujui, 1 = disetujui
                'tanggal_pengajuan' => '2024-01-10',
                'tanggal_persetujuan' => null, // Null karena belum disetujui
            ],
            [
                'irs_id' => 2,
                'mahasiswa_id' => 2, // ID mahasiswa dengan NIM 24060122140118
                'nim' => '24060122140118',
                'nama' => 'Arya Ajisadda Haryanto',
                'program_studi' => 'S1 Informatika',
                'semester' => 5,
                'tahun_akademik' => '2024/2025',
                'kode_mk' => 'IF402',
                'nama_mk' => 'Sistem Basis Data',
                'kelas' => 'A',
                'sks' => 3,
                'status' => 0, // Sudah disetujui
                'tanggal_pengajuan' => '2024-01-12',
                'tanggal_persetujuan' => null,
            ],
        ];

        // Insert data ke tabel IRS
        DB::table('irs')->insert($irsData);
    }
}