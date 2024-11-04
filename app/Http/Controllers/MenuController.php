<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\JadwalMk;

class MenuController extends Controller
{
    // Controller untuk Mahasiswa
    public function jadwalKuliah()
    {
        $user = Auth::user();
        return view('mahasiswa.jadwalKuliah', compact('user'));
    }

    public function herReg()
    {
        $user = Auth::user();
        return view('mahasiswa.herReg', compact('user'));
    }

    public function khs()
    {
        $user = Auth::user();
        return view('mahasiswa.khs', compact('user'));
    }

    public function irs()
    {
        $user = Auth::user();
        return view('mahasiswa.irs', compact('user'));
    }

    // Controller untuk Dekan
    public function pengajuanJadwalDekan()
    {
        $user = Auth::user();
        return view('dekan.listPengajuanJadwal', compact('user'));
    }

    public function pengajuanRuangKuliahDekan()
    {
        $user = Auth::user();
        return view('dekan.listPengajuanRuang', compact('user'));
    }

    public function detailListPengajuanJadwal()
    {
        $user = Auth::user();
        $jadwalList = JadwalMk::all(); // Mengambil semua jadwal
        return view('dekan.detailListPengajuanJadwal', compact('user', 'jadwalList'));
    }
    
    public function detailListPengajuanJadwalByProgram($program_studi)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = Auth::user();

        // Menentukan jadwal berdasarkan program studi
        if ($program_studi === 'Informatika') {
            $jadwalPengajuan = JadwalMk::where('kode_mk', 'like', 'PAIK%')->get();
        } elseif ($program_studi === 'Bioteknologi') {
            $jadwalPengajuan = JadwalMk::where(function($query) {
                $query->where('kode_mk', 'like', 'LAB%')
                      ->orWhere('kode_mk', 'like', 'PAB%'); // Ambil jadwal untuk Bioteknologi
            })->get();
        } else {
            $jadwalPengajuan = collect();
        }

        // Mengirim data pengguna, jadwalPengajuan, dan program_studi ke tampilan
        return view('dekan.detailListPengajuanJadwal', compact('jadwalPengajuan', 'user', 'program_studi'));
    }

    // Controller untuk Dosen Wali
    public function pengajuanIrsMahasiswa()
    {
        $user = Auth::user();
        return view('dosenwali.listPengajuanIRS', compact('user'));
    }

    public function mahasiswaPerwalian()
    {
        $user = Auth::user();
        return view('dosenwali.listMahasiswaPerwalian', compact('user'));
    }

    // Controller untuk Akademik
    public function listRuangKuliah()
    {
        $user = Auth::user();
        return view('akademik.listRuangKuliah', compact('user'));
    }

    public function inputRuangKuliah()
    {
        $user = Auth::user();
        return view('akademik.inputRuangKuliah', compact('user'));
    }
}