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
                'kode_ruangan'=> 'E101',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '2',
                'jurusan'=> 'S1-INFORMATIKA',
                'kode_ruangan'=> 'E102',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '3',
                'jurusan'=> 'S1-INFORMATIKA',
                'kode_ruangan'=> 'E103',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '4',
                'jurusan'=> 'S1-INFORMATIKA',
                'kode_ruangan'=> 'A303',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '5',
                'jurusan'=> 'S1-INFORMATIKA',
                'kode_ruangan'=> 'A304',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '6',
                'jurusan'=> 'S1-INFORMATIKA',
                'kode_ruangan'=> 'K102',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '7',
                'jurusan'=> 'S1-INFORMATIKA',
                'kode_ruangan'=> 'K101',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '8',
                'jurusan'=> 'S1-INFORMATIKA',
                'kode_ruangan'=> 'E101',
                'kapasitas'=> '50',
            ],            
            [
                'id'=> '9',
                'jurusan'=> 'S1-STATISTIKA',
                'kode_ruangan'=> 'B101',
                'kapasitas'=> '50',
            ],
        ];

        // Insert data ke tabel kaprodi
        DB::table('ruangan')->insert($ruangan);
    }
}
