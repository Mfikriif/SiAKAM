<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuanganSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Data untuk tabel ruangan
        $ruangan = [
            [
                'id'=> '1',
                'jurusan'=> 'S1-INFORMATIKA',
                'kode_ruangan'=> 'E101, E102, E103',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '2',
                'jurusan'=> 'S1-STATISTIKA',
                'kode_ruangan'=> 'B101',
                'kapasitas'=> '50',
            ],
        ];

        // Insert data ke tabel kaprodi
        DB::table('ruangan')->insert($ruangan);
    }
}
