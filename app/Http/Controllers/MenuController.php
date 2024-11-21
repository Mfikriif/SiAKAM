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