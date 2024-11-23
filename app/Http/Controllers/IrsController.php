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
        // $totalSks = 0;
        $totalSksAmbil = irs::where('mahasiswa_id',$mahasiswa->id)->get()->sum('sks');
        // dd($totalSksAmbil);

        $irsDiambil = DB::table('irs')
        ->where('mahasiswa_id', $mahasiswa->id)
        ->get(['kode_mk','kelas'])
        ->toArray();

        // menampilkan list mata kuliah diluar semester berjalan
        $listMK = JadwalMK::select('kode_mk','nama')
        ->where('semester','<>',$semesterMHS)
        ->distinct()
        ->get();

        $dataKhs = DB::table('khs')
        ->where('nim',$mahasiswa->nim)
        ->where('semester', 4)
        ->whereNotNull('nilai_huruf')
        ->get(['sks','nilai_huruf']);

        if($dataKhs->isEmpty()){
            return reesponse()->json(['message' => 'Data tidak ditemukan','ip semester' => 0],404);
        }

        $nilai_bobot = [
            'A' => 4,
            'B' => 3,
            'C' => 2,
            'D' => 1,
            'E' => 0,
        ];

        $totalBobot = 0;
        $totalSks = 0;

        foreach ($dataKhs as $khs) {
            $bobot = $nilai_bobot[$khs->nilai_huruf] ?? 0;
            $totalBobot += $khs->sks * $bobot;
            $totalSks += $khs->sks;
        }

        $ipSemester = $totalSks > 0 ? round( $totalBobot / $totalSks, 2): 0;

        if($ipSemester >= 3){
            $totalSksDiambil = 24;
        }else if ($ipSemester > 2.5 && $ipSemester <= 2.9){
            $totalSksDiambil = 20;
        }else {
            $totalSksDiambil = 18;
        }
        // dd($ipSemester);

        return view('mahasiswa.irs', compact('jadwal_MK','user','irsDiambil','mahasiswa','totalSksAmbil','listMK','ipSemester','totalSksDiambil'));
    }

    public function store(Request $request)
    {   
        try {
            $user = Auth::user();
            $mahasiswa = Mahasiswa::where('email', $user->email)->first();
            
            if (!$mahasiswa) {
                return redirect()->back()->withErrors(['message' => 'Mahasiswa tidak ditemukan.']);
            }
    
            // Hitung total SKS yang sudah diambil
            $totalSksAmbil = irs::where('mahasiswa_id', $mahasiswa->id)->get()->sum('sks');
    
            // Ambil IP Semester untuk menghitung batas maksimal SKS
            $dataKhs = DB::table('khs')
                ->where('nim', $mahasiswa->nim)
                ->where('semester', 4) // Sesuaikan semester jika perlu
                ->whereNotNull('nilai_huruf')
                ->get(['sks', 'nilai_huruf']);
    
            $nilai_bobot = [
                'A' => 4,
                'B' => 3,
                'C' => 2,
                'D' => 1,
                'E' => 0,
            ];
    
            $totalBobot = 0;
            $totalSks = 0;
    
            foreach ($dataKhs as $khs) {
                $bobot = $nilai_bobot[$khs->nilai_huruf] ?? 0;
                $totalBobot += $khs->sks * $bobot;
                $totalSks += $khs->sks;
            }
    
            $ipSemester = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;
    
            // Tentukan total SKS yang diperbolehkan berdasarkan IP semester
            if ($ipSemester >= 3) {
                $totalSksDiambil = 24;
            } elseif ($ipSemester > 2.5 && $ipSemester <= 2.9) {
                $totalSksDiambil = 20;
            } else {
                $totalSksDiambil = 18;
            }
    
            // Validasi apakah total SKS yang sudah diambil melebihi batas
            if (($totalSksAmbil + $request->sks)  > $totalSksDiambil) {
                return redirect()->back()->withErrors([
                    'message' => 'Tidak dapat mengambil mata kuliah baru. Total SKS yang sudah diambil (' . $totalSksAmbil . ') telah melebihi batas maksimal (' . $totalSksDiambil . ').'
                ]);
            }
    
            // Validasi request
            $request->validate([
                'kode_mk' => 'required',
                'nama_mk' => 'required',
                'semester' => 'required|integer',
                'kelas' => 'required',
                'sks' => 'required',
            ]);
    
            // Buat data IRS
            $irs = Irs::create([
                'mahasiswa_id' => $mahasiswa->id,
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'program_studi' => $mahasiswa->jurusan,
                'semester' => $request->semester,
                'kode_mk' => $request->kode_mk,
                'nama_mk' => $request->nama_mk,
                'kelas' => $request->kelas,
                'sks' => $request->sks,
                'tanggal_pengajuan' => now()
            ]);
    
            // Sinkronisasi ke tabel KHS
            khs::create([
                'nim' => $irs->nim,
                'nama' => $irs->nama,
                'program_studi' => $irs->program_studi,
                'semester' => $irs->semester,
                'kode_mk' => $irs->kode_mk,
                'nama_mk' => $irs->nama_mk,
                'sks' => $irs->sks,
            ]);
    
            return redirect()->back()->with('success', 'Pengambilan IRS berhasil.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Gagal mengambil IRS: ' . $e->getMessage()], 500);
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

        $matakuliah = JadwalMK::where('kode_mk', $kodeMK)->get();
        
        if ($matakuliah->isEmpty()) {
            return response()->json(['error' => 'Mata kuliah tidak ditemukan'], 404);
        }

        return response()->json($matakuliah);
    }
}

