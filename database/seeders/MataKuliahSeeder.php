<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    public function run()
    {
        DB::table('mata_kuliah')->insert([

            // Informatika Semester 5
            ['kode_mk' => 'PAIK6501', 'nama_mk' => 'Pengembangan Berbasis Platform', 'semester' => '5', 'sks' => 4, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6702', 'nama_mk' => 'Teori Bahasa dan Otomata', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6502', 'nama_mk' => 'Komputasi Tersebar dan Paralel', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6505', 'nama_mk' => 'Pembelajaran Mesin', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6503', 'nama_mk' => 'Sistem Informasi', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6504', 'nama_mk' => 'Proyek Perangkat Lunak', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],

            // Informatika Semester 1
            ['kode_mk' => 'PAIK6102', 'nama_mk' => 'Dasar Pemrograman', 'semester' => '1', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6103', 'nama_mk' => 'Dasar Sistem', 'semester' => '1', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6104', 'nama_mk' => 'Logika Informatika', 'semester' => '1', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6105', 'nama_mk' => 'Struktur Diskrit', 'semester' => '1', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6101', 'nama_mk' => 'Matematika I', 'semester' => '1', 'sks' => 3, 'sifat' => 'WAJIB'],

            // Informatika Semester 2
            ['kode_mk' => 'PAIK6202', 'nama_mk' => 'Algoritma dan Pemrograman', 'semester' => '2', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6203', 'nama_mk' => 'Organisasi dan Arsitektur Komputer', 'semester' => '2', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6603', 'nama_mk' => 'Masyarakat dan Etika Profesi', 'semester' => '2', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6201', 'nama_mk' => 'Matematika II', 'semester' => '2', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6402', 'nama_mk' => 'Jaringan Komputer', 'semester' => '2', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6204', 'nama_mk' => 'Aljabar Linier', 'semester' => '2', 'sks' => 3, 'sifat' => 'WAJIB'],

            // Informatika Semester 3
            ['kode_mk' => 'PAIK6303', 'nama_mk' => 'Basis Data', 'semester' => '3', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6301', 'nama_mk' => 'Struktur Data', 'semester' => '3', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6506', 'nama_mk' => 'Keamanan dan Jaminan Informasi', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6305', 'nama_mk' => 'Interaksi Manusia dan Komputer', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6304', 'nama_mk' => 'Metode Numerik', 'semester' => '3', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6302', 'nama_mk' => 'Sistem Operasi', 'semester' => '3', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6306', 'nama_mk' => 'Statistika', 'semester' => '3', 'sks' => 3, 'sifat' => 'WAJIB'],

            // Informatika Semester 4
            ['kode_mk' => 'PAIK6404', 'nama_mk' => 'Grafika dan Komputasi Visual', 'semester' => '4', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6401', 'nama_mk' => 'Pemrograman Berorientasi Objek', 'semester' => '4', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6406', 'nama_mk' => 'Sistem Cerdas', 'semester' => '4', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6601', 'nama_mk' => 'Analisis dan Strategi Algoritma', 'semester' => '4', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6403', 'nama_mk' => 'Manajemen Basis Data', 'semester' => '4', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PAIK6405', 'nama_mk' => 'Rekayasa Perangkat Lunak', 'semester' => '4', 'sks' => 3, 'sifat' => 'WAJIB'],

            // Bioteknologi Semester 5
            ['kode_mk' => 'PABL6501', 'nama_mk' => 'Teknik Komunikasi Ilmiah', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABL6502', 'nama_mk' => 'Embriologi Tumbuhan', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABL6503', 'nama_mk' => 'Mikroteknik Hewan', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABL6504', 'nama_mk' => 'Biosistematika', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABL6505', 'nama_mk' => 'Genetika Rekombinan', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABL6506', 'nama_mk' => 'Biokonservasi', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABL6507', 'nama_mk' => 'Biofisika', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABL6508', 'nama_mk' => 'Kerja Praktek', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'LABL6509', 'nama_mk' => 'Dasar-Dasar Bioteknologi', 'semester' => '5', 'sks' => 3, 'sifat' => 'WAJIB'],

            // Bioteknologi Semester 1
            ['kode_mk' => 'PABT6104', 'nama_mk' => 'Kimia Dasar', 'semester' => '1', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6105', 'nama_mk' => 'Praktikum Kimia Dasar', 'semester' => '1', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6101', 'nama_mk' => 'Biologi Dasar', 'semester' => '1', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'LABT6107', 'nama_mk' => 'Pengantar Bioteknologi', 'semester' => '1', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6106', 'nama_mk' => 'Praktikum Biologi Dasar', 'semester' => '1', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6102', 'nama_mk' => 'Matematika Dasar', 'semester' => '1', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6108', 'nama_mk' => 'Biofisika', 'semester' => '1', 'sks' => 2, 'sifat' => 'WAJIB'],


            // Semester 2
            ['kode_mk' => 'PABT6201', 'nama_mk' => 'Biokimia', 'semester' => '2', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6202', 'nama_mk' => 'Praktikum Biokimia', 'semester' => '2', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6203', 'nama_mk' => 'Biologi Sel', 'semester' => '2', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6207', 'nama_mk' => 'Praktikum Genetika', 'semester' => '2', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6208', 'nama_mk' => 'Mikrobiologi Umum', 'semester' => '2', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6209', 'nama_mk' => 'Praktikum Mikrobiologi Umum', 'semester' => '2', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6206', 'nama_mk' => 'Genetika', 'semester' => '2', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6210', 'nama_mk' => 'Biodiversitas SDH', 'semester' => '2', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6205', 'nama_mk' => 'Praktikum Dasar-Dasar Fisiologi', 'semester' => '2', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'LABT6211', 'nama_mk' => 'Biosafety', 'semester' => '2', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6204', 'nama_mk' => 'Dasar-Dasar Fisiologi', 'semester' => '2', 'sks' => 2, 'sifat' => 'WAJIB'],

            // Semester 3
            ['kode_mk' => 'PABT6312', 'nama_mk' => 'Praktikum Enzimologi', 'semester' => '3', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6301', 'nama_mk' => 'Biologi Molekuler', 'semester' => '3', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6311', 'nama_mk' => 'Enzimologi', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6305', 'nama_mk' => 'Biostatistik', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6304', 'nama_mk' => 'Biodiversitas Mikroba', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6308', 'nama_mk' => 'Fisiologi Mikroba', 'semester' => '3', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'LABT6306', 'nama_mk' => 'Rekayasa Genetika', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6504', 'nama_mk' => 'Biokimia Lingkungan', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6307', 'nama_mk' => 'Praktikum Rekayasa Genetika', 'semester' => '3', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6303', 'nama_mk' => 'Praktikum Teknologi Bioproses', 'semester' => '3', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6302', 'nama_mk' => 'Teknologi Bioproses', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6309', 'nama_mk' => 'Mikologi', 'semester' => '3', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6310', 'nama_mk' => 'Praktikum Mikologi', 'semester' => '3', 'sks' => 1, 'sifat' => 'WAJIB'],

            // Semester 4
            ['kode_mk' => 'PABT6408', 'nama_mk' => 'Mikrobiologi Farmasi', 'semester' => '4', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6406', 'nama_mk' => 'Praktikum Kultur Jaringan Tanaman', 'semester' => '4', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'LABT6411', 'nama_mk' => 'Bioinformatika', 'semester' => '4', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6407', 'nama_mk' => 'Metodologi penelitian dan Rancangan Percobaan', 'semester' => '4', 'sks' => 3, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6403', 'nama_mk' => 'Bioteknologi Industri', 'semester' => '4', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6409', 'nama_mk' => 'Bioteknologi lingkungan', 'semester' => '4', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6412', 'nama_mk' => 'Praktikum Bioinformatika', 'semester' => '4', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6410', 'nama_mk' => 'Instrumentasi bioteknologi', 'semester' => '4', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6401', 'nama_mk' => 'Mikrobiologi Industri', 'semester' => '4', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6405', 'nama_mk' => 'Kultur Jaringan Tanaman', 'semester' => '4', 'sks' => 2, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6402', 'nama_mk' => 'Praktikum Mikrobiologi Industri', 'semester' => '4', 'sks' => 1, 'sifat' => 'WAJIB'],
            ['kode_mk' => 'PABT6404', 'nama_mk' => 'Bioetika', 'semester' => '4', 'sks' => 1, 'sifat' => 'WAJIB']
        ]);
    }
}