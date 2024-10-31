<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuanganSeeder extends Seeder
{
    public function run()
    {
        DB::table('ruangan')->insert([
            [
                'kode_ruangan' => 'E101',
                'kapasitas' => 50,
            ],
            [
                'kode_ruangan' => 'A303',
                'kapasitas' => 30,
            ],
            [
                'kode_ruangan' => 'B202',
                'kapasitas' => 40,
            ],
            [
                'kode_ruangan' => 'C404',
                'kapasitas' => 25,
            ],
            [
                'kode_ruangan' => 'D505',
                'kapasitas' => 35,
            ],
        ]);
    }
}