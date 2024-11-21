<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\JadwalMk;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Ambil total sks yang telah di ambil
        $totalSks = irs::where('mahasiswa_id',$mahasiswa->id)->get()->sum('sks');

        $irsDiambil = DB::table('irs')
        ->where('mahasiswa_id', $mahasiswa->id)
        ->pluck('kode_mk')
        ->toArray();

        $listMK = JadwalMK::where('semester','<>',$semesterMHS)->get();
        // dd($listMk);
        return view('mahasiswa.irs', compact('jadwal_MK','user','irsDiambil','mahasiswa','totalSks','listMK'));
    }

    public function store(Request $request)
    {   
        try {
            $user = Auth::user();
            $mahasiswa = Mahasiswa::where('email', $user->email)->first();
            
            if (!$mahasiswa) {
                return redirect()->back()->withErrors(['message' => 'Mahasiswa not found.']);
            }
    
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
    
            return redirect()->back()->with('success', 'Pengambilan IRS berhasil.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Gagal mengambil IRS: ' . $e->getMessage()],500);
        }
    }
    


    public function delete(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required',
            'nama_mhs' => 'required',
        ]);
    
        try {
            $irs = Irs::where('kode_mk', $validated['kode_mk'])
                      ->where('nama', $validated['nama_mhs'])
                      ->first();
            
            if ($irs) {
                $irs->delete();
            }
    
            khs::where('kode_mk', $validated['kode_mk'])
                ->where('nama', $validated['nama_mhs'])
                ->delete();
    
            // Make sure to return a success message even if no records are found
            return redirect()->back()->with('success', 'Penghapusan IRS berhasil.');
    
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Gagal mengambil IRS: ' . $e->getMessage()],500);

        }
    }
    

    public function getMatakuliahDetail($kodeMK) {
        // Fetch all classes (A, B, C, etc.) for the selected course
        $matakuliah = JadwalMK::where('kode_mk', $kodeMK)->get();
        
        if ($matakuliah->isEmpty()) {
            return response()->json(['error' => 'Mata kuliah tidak ditemukan'], 404);
        }

        return response()->json($matakuliah);
    }

    public function getKhs(){

            
    }

}

