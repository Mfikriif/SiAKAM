<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    public function run()
    {
        DB::table('mata_kuliah')->insert([
            [
                'kode_mk' => 'PAIK6501',
                'nama_mk' => 'Pengembangan Berbasis Platform',
                'semester' => '5',
                'sks' => 4,
                'pengampu' => 'Sandy Kurniawan, S.Kom., M.Kom., Adhe Setya Pramayoga, M.T., Henri Tantyoko, S.Kom., M.Kom.',
                'sifat' => 'WAJIB'
            ],
            [
                'kode_mk' => 'PAIK6702',
                'nama_mk' => 'Teori Bahasa dan Otomata',
                'semester' => '5',
                'sks' => 3,
                'pengampu' => 'Priyo Sidik Sasongko, S.Si., M.Kom., Etna Vianita, S.Mat., M.Mat., Dr. Yeva Fadhilah Ashari, S.Si., M.Si.',
                'sifat' => 'WAJIB'
            ],
            [
                'kode_mk' => 'PAIK6502',
                'nama_mk' => 'Komputasi Tersebar dan Paralel',
                'semester' => '5',
                'sks' => 3,
                'pengampu' => 'Guruh Aryotejo, S.Kom., M.Sc., Adhe Setya Pramayoga, M.T., Dr.Eng. Adi Wibowo, S.Si., M.Kom.',
                'sifat' => 'WAJIB'
            ],
            [
                'kode_mk' => 'PAIK6505',
                'nama_mk' => 'Pembelajaran Mesin',
                'semester' => '5',
                'sks' => 3,
                'pengampu' => 'Dr. Retno Kusumaningrum, S.Si., M.Kom., Rismiyati, B.Eng, M.Cs',
                'sifat' => 'WAJIB'
            ],
            [
                'kode_mk' => 'PAIK6503',
                'nama_mk' => 'Sistem Informasi',
                'semester' => '5',
                'sks' => 3,
                'pengampu' => 'Beta Noranita, S.Si., M.Kom., Dr. Indra Waspada, S.T., M.T.I',
                'sifat' => 'WAJIB'
            ],
            [
                'kode_mk' => 'PAIK6504',
                'nama_mk' => 'Proyek Perangkat Lunak',
                'semester' => '5',
                'sks' => 3,
                'pengampu' => 'Dinar Mutiara Kusumo Nugraheni, S.T., M.InfoTech.(Comp)., Ph.D., Dr. Aris Puji Widodo, S.Si., M.T., Yunila Dwi Putri Ariyanti, S.Kom., M.Kom.',
                'sifat' => 'WAJIB'
            ]
        ]);
    }
}