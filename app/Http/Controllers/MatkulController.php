<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use App\Models\Jadwal_MK;
use App\Models\Matkul;
use App\Models\Ruangan;

class MatkulController extends Controller
{
    public function getMatkul(){
        // Ambil semua data jadwal mata kuliah beserta relasinya
        $jadwal_MK = Jadwal_MK::all();
        // Kirim data ke tampilan
        return view('mahasiswa.irs', compact('jadwal_MK'));
    }
}

