<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use App\Models\JadwalMk;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Irs;
use App\Models\irs_detail;

class IrsController extends Controller
{
    public function index(){
        
        // Ambil semester mahasiswa
        $user = Auth::user();
        
        $mahasiswa = Mahasiswa::where('email',$user->email)->first();

        $semesterMHS = $mahasiswa->semester;
        // Ambil semua data jadwal mata kuliah
        $jadwal_MK = JadwalMK::where('semester',$semesterMHS)->get();

        // $statusIrs = Irs::where('id',$mahasiswa->id)->first()->status;

        // Kirim data ke tampilan
        return view('mahasiswa.irs', compact('jadwal_MK','user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('email',$user->email)->first();

        $semesterMHS = $mahasiswa->semester;

        $request->validate([
            'kode_mk' => 'required',
            'semester' => 'required|integer',
        ]);

        $irs = Irs::create([
            'id' => $mahasiswa->id,
            'semester' => $request->semester,
            'tanggal_pengajuan' => now()
        ]);

        irs_detail::create([
            'irs_id' => $irs->irs_id,
            'kode_mk' => $request->kode_mk
        ]);

        return redirect()->route('mahasiswa.irs')->with('success','Pengambila IRS Berhasil');
    }

}

