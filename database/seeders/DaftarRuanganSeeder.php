<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarRuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ruangan = [
            ['kode_ruangan' => 'E101', 'keterangan' => 'Ruang Kuliah Gedung E Lantai 1'],
            ['kode_ruangan' => 'E102', 'keterangan' => 'Ruang Kuliah Gedung E Lantai 1'],
            ['kode_ruangan' => 'E103', 'keterangan' => 'Ruang Kuliah Gedung E Lantai 1'],
            ['kode_ruangan' => 'A101', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 1'],
            ['kode_ruangan' => 'A102', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 1'],
            ['kode_ruangan' => 'A103', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 1'],
            ['kode_ruangan' => 'A104', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 1'],
            ['kode_ruangan' => 'A201', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 2'],
            ['kode_ruangan' => 'A202', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 2'],
            ['kode_ruangan' => 'A203', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 2'],
            ['kode_ruangan' => 'A204', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 2'],
            ['kode_ruangan' => 'A301', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 3'],
            ['kode_ruangan' => 'A302', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 3'],
            ['kode_ruangan' => 'A303', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 3'],
            ['kode_ruangan' => 'A304', 'keterangan' => 'Ruang Kuliah Gedung A Lantai 3'],
            ['kode_ruangan' => 'K101', 'keterangan' => 'Ruang Kuliah Gedung K Lantai 1'],
            ['kode_ruangan' => 'K102', 'keterangan' => 'Ruang Kuliah Gedung K Lantai 1'],
            ['kode_ruangan' => 'K201', 'keterangan' => 'Ruang Kuliah Gedung K Lantai 2'],
            ['kode_ruangan' => 'K202', 'keterangan' => 'Ruang Kuliah Gedung K Lantai 2'],
            ['kode_ruangan' => 'B101', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 1'],
            ['kode_ruangan' => 'B102', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 1'],
            ['kode_ruangan' => 'B103', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 1'],
            ['kode_ruangan' => 'B104', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 1'],
            ['kode_ruangan' => 'B201', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 2'],
            ['kode_ruangan' => 'B202', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 2'],
            ['kode_ruangan' => 'B203', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 2'],
            ['kode_ruangan' => 'B204', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 2'],
            ['kode_ruangan' => 'B301', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 3'],
            ['kode_ruangan' => 'B302', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 3'],
            ['kode_ruangan' => 'B303', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 3'],
            ['kode_ruangan' => 'B304', 'keterangan' => 'Ruang Kuliah Gedung B Lantai 3'],
            ['kode_ruangan' => 'C101', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 1'],
            ['kode_ruangan' => 'C102', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 1'],
            ['kode_ruangan' => 'C103', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 1'],
            ['kode_ruangan' => 'C104', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 1'],
            ['kode_ruangan' => 'C201', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 2'],
            ['kode_ruangan' => 'C202', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 2'],
            ['kode_ruangan' => 'C203', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 2'],
            ['kode_ruangan' => 'C204', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 2'],
            ['kode_ruangan' => 'C301', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 3'],
            ['kode_ruangan' => 'C302', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 3'],
            ['kode_ruangan' => 'C303', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 3'],
            ['kode_ruangan' => 'C304', 'keterangan' => 'Ruang Kuliah Gedung C Lantai 3'],
            ['kode_ruangan' => 'D101', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 1'],
            ['kode_ruangan' => 'D102', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 1'],
            ['kode_ruangan' => 'D103', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 1'],
            ['kode_ruangan' => 'D104', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 1'],
            ['kode_ruangan' => 'D201', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 2'],
            ['kode_ruangan' => 'D202', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 2'],
            ['kode_ruangan' => 'D203', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 2'],
            ['kode_ruangan' => 'D204', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 2'],
            ['kode_ruangan' => 'D301', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 3'],
            ['kode_ruangan' => 'D302', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 3'],
            ['kode_ruangan' => 'D303', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 3'],
            ['kode_ruangan' => 'D304', 'keterangan' => 'Ruang Kuliah Gedung D Lantai 3'],
        ];

        DB::table('daftar_ruangan')->insert($ruangan);
    }
}
