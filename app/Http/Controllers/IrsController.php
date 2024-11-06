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
use App\Models\khs;

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
        return view('mahasiswa.irs', compact('jadwal_MK','user',));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('email',$user->email)->first();

        $semesterMHS = $mahasiswa->semester;

        $request->validate([
            'kode_mk' => 'required',
            'nama_mk' => 'required',
            'semester' => 'required|integer',
            'sks' => 'required',
        ]);

        $irs = Irs::create([
            'mahasiswa_id' => $mahasiswa->id,
            'nama' => $mahasiswa->nama,
            'program_studi' => $mahasiswa->jurusan,
            'semester' => $request->semester,
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks,
            'tanggal_pengajuan' => now()
        ]);

        khs::create([
            'nama' => $irs->nama,
            'program_studi' => $irs->program_studi,
            'semester' => $irs->semester,
            'kode_mk' => $irs->kode_mk,
            'nama_mk' => $irs->nama_mk,
            'sks' => $irs->sks,
        ]);

        return redirect()->route('mahasiswa.irs')->with('success','Pengambila IRS Berhasil');
    }

}

