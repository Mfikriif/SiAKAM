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
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class IrsController extends Controller
{
    public function index(){
        
        // Ambil data mahasiswa yang sedang login
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();

        $semesterMHS = $mahasiswa->semester;
        $jurusan = $mahasiswa->jurusan;

        // Ambil tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('is_active', true)->first();

        if (!$tahunAjaran) {
            return redirect()->back()->withErrors(['message' => 'Tahun ajaran aktif tidak ditemukan.']);
        }

        // Hitung batas 2 minggu dari awal semester
        $startDate = Carbon::parse($tahunAjaran->start_date);
        $batasDuaMinggu = $startDate->addDays(14);

        // Tentukan apakah waktu sekarang sudah melewati 2 minggu
        $isBeyondTwoWeeks = Carbon::now()->greaterThan($batasDuaMinggu);

        $statusAktif = $mahasiswa->status;
        // Ambil semua data jadwal mata kuliah sesuai semester
        $jadwal_MK = JadwalMK::where('semester', $semesterMHS);

        // Filter jadwal mata kuliah berdasarkan jurusan mahasiswa
        if ($jurusan == 'S1 Informatika') {
            $jadwal_MK = $jadwal_MK->where(function($query) {
                $query->where('kode_mk', 'like', 'PAIK%');
            });
        } else if ($jurusan == 'S1 Bioteknologi') {
            $jadwal_MK = $jadwal_MK->where(function($query) {
                $query->where('kode_mk', 'like', 'LAB%')
                      ->orWhere('kode_mk', 'like', 'PAB%');
            });
        }

        $alertStatusAktif = null;
        // Debugging: Tampilkan SQL query
        if($statusAktif == 1){
            $jadwal_MK = $jadwal_MK->get();
        }else if($statusAktif == -1){
            $alertStatusAktif = 'ANDA TIDAK BISA MENGAMBIL PERKULIAHAN DI SEMESTER INI';
        }else{
            $alertStatusAktif = 'Anda belum melakukan Her-registrasi, Silahkan lakukan Her-registrasi terlebih dahulu';
        }
        // dd($jadwal_MK);

        // Ambil total SKS yang telah diambil
        $totalSksAmbil = Irs::where('mahasiswa_id', $mahasiswa->id)->sum('sks');

        $irsDiambil = DB::table('irs')
                        ->where('mahasiswa_id', $mahasiswa->id)
                        ->get(['kode_mk','kelas'])
                        ->toArray();

        $ringkasanIRS = Irs::where('mahasiswa_id', $mahasiswa->id)
        ->join('jadwal_mk', 'irs.kode_mk', '=', 'jadwal_mk.kode_mk')
        ->get(['irs.kode_mk', 'jadwal_mk.nama', 'irs.sks', 'irs.kelas']);

        // Tanggal sekarang dikurangi 10 hari
        $tanggalBatas = Carbon::now()->subDays(10);

        // Query list mata kuliah
        $listMK = JadwalMk::select('kode_mk', 'nama', 'updated_at')
                    ->where('persetujuan', 1)
                    ->whereDate('updated_at', '<=', $tanggalBatas) // H+10 hari
                    ->distinct()
                    ->get();

        // Hitung IP semester sebelumnya
        $dataKhs = DB::table('khs')
                    ->where('nim', $mahasiswa->nim)
                    ->where('semester', $semesterMHS - 1)
                    ->whereNotNull('nilai_huruf')
                    ->get(['sks','nilai_huruf']);

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
        if ($ipSemester >= 3.00) {
            $totalSksDiambil = 24;
        } elseif ($ipSemester >= 2.50 && $ipSemester <= 2.99) {
            $totalSksDiambil = 22;
        } else if ($ipSemester >= 2.00 && $ipSemester <= 2.49 ){
            $totalSksDiambil = 20 ;
        } else {
            $totalSksDiambil = 18;
        }
        // Mengambil data KHS mahasiswa berdasarkan nim dan mengelompokkan berdasarkan semester
        $khsMahasiswa = DB::table('irs')
        ->where('nim', $mahasiswa->nim)
        ->get()
        ->groupBy('tahun_akademik', 'asc');

        $statusIRS = Irs::where('mahasiswa_id', $mahasiswa->id)
        ->where('semester', $semesterMHS)
        ->first();
        $statusIRSLock = Irs::where('mahasiswa_id', $mahasiswa->id)->first();
        // Pastikan $statusIRS tidak null sebelum mengakses properti
        $statusIRSDua = $statusIRS ? $statusIRS->status : null;
        if ($statusIRSLock && $statusIRSLock->status == 1) {
            return view('mahasiswa.irs-locked', compact('mahasiswa', 'user', 'khsMahasiswa'));
        }
    
        // dd($statusIRS);
        return view('mahasiswa.irs', compact('jadwal_MK','user','irsDiambil','mahasiswa','totalSksAmbil','listMK','ipSemester','totalSksDiambil','statusIRS','statusIRSDua','alertStatusAktif','ringkasanIRS','isBeyondTwoWeeks'));
    }

    
    public function getRingkasan()
    {
        $userId = Auth::id();

        // Ambil ringkasan IRS yang diambil oleh user
        $ringkasanIRS = Irs::where('mahasiswa_id', $userId)
                            ->join('jadwal_mk', 'irs.kode_mk', '=', 'jadwal_mk.kode_mk')
                            ->get(['irs.kode_mk', 'jadwal_mk.nama', 'irs.sks', 'irs.kelas']);

        return response()->json($ringkasanIRS);
    }

    public function store(Request $request)
    {   
        try {
            $user = Auth::user();
            $mahasiswa = Mahasiswa::where('email', $user->email)->first();
            
            if (!$mahasiswa) {
                return redirect()->back()->withErrors(['message' => 'Mahasiswa tidak ditemukan.']);
            }

            //validasi matakuliah apakah sudah diambil atau belum
            $mataKuliahExist =Irs::where('mahasiswa_id',$mahasiswa->id)
            ->where('kode_mk',$request->kode_mk)
            ->where('nama_mk',$request->nama_mk)
            ->exists(); 
            
            // dd($mataKuliahExist);
            if($mataKuliahExist){
                return redirect()->back()->with([
                    'alert_type'=>'error',
                    'alert_message'=> 'Mata kuliah sudah diambil.'
                ]);
            }

              // Pengecekan jadwal tabrakan (jam dan hari)
            $jadwalTabrakan = Irs::where('mahasiswa_id', $mahasiswa->id)
            ->where('hari', $request->hari)
            ->where('jam_mulai',$request->jam_mulai)
            ->exists()
            ;

            if ($jadwalTabrakan) {
                return redirect()->back()->with([
                    'alert_type' => 'error',
                    'alert_message' => 'Jadwal mata kuliah bertabrakan dengan jadwal yang sudah diambil.'
                ]);
            }

            // Hitung total SKS yang sudah diambil
            $totalSksAmbil = irs::where('mahasiswa_id', $mahasiswa->id)->get()->sum('sks');
    
            // Ambil IP Semester untuk menghitung batas maksimal SKS
            $dataKhs = DB::table('khs')
                ->where('nim', $mahasiswa->nim)
                ->where('semester', $mahasiswa->semester - 1) // Sesuaikan semester jika perlu
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
            if ($ipSemester >= 3.00) {
                $totalSksDiambil = 24;
            } elseif ($ipSemester >= 2.50 && $ipSemester <= 2.99) {
                $totalSksDiambil = 22;
            } else if ($ipSemester >= 2.00 && $ipSemester <= 2.49 ){
                $totalSksDiambil = 20 ;
            } else {
                $totalSksDiambil = 18;
            }
    
            // Validasi apakah total SKS yang sudah diambil melebihi batas
            if (($totalSksAmbil + $request->sks)  > $totalSksDiambil) {
                return redirect()->back()->with([
                    'alert_type' => 'error' ,
                    'alert_message' => 'Tidak dapat mengambil mata kuliah baru. Total SKS yang sudah diambil (' . $totalSksAmbil . ') telah melebihi batas maksimal (' . $totalSksDiambil . ').'
                ]);
            }

            $tahunAjaran = TahunAjaran::where('is_active', 1)->first();
            $semesterAkademikAktif = $tahunAjaran->tahun. ' '.$tahunAjaran->semester;
    
            // Validasi request
            $request->validate([
                'kode_mk' => 'required',
                'nama_mk' => 'required',
                'semester' => 'required|integer',
                'kelas' => 'required',
                'sks' => 'required',
                'hari' => 'required',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
            ]);

            // Buat data IRS
            $irs = Irs::create([
                'mahasiswa_id' => $mahasiswa->id,
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'program_studi' => $mahasiswa->jurusan,
                'semester' => $request->semester,
                'tahun_akademik' => $semesterAkademikAktif,
                'kode_mk' => $request->kode_mk,
                'nama_mk' => $request->nama_mk,
                'kelas' => $request->kelas,
                'sks' => $request->sks,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->sks,
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
            'kelas' => 'required',
        ]);
    
        try {
            $irs = Irs::where('kode_mk', $validated['kode_mk'])
                      ->where('nama', $validated['nama_mhs'])
                      ->where('kelas', $validated['kelas'])
                      ->first();
    
            if ($irs) {
                $irs->delete();
            }
    
            khs::where('kode_mk', $validated['kode_mk'])
                ->where('nama', $validated['nama_mhs'])
                ->delete();
                return redirect()->back()->with([
                    'alert_type' => 'success',
                    'alert_message' => 'Jadwal mata kuliah berhasil di hapus.'
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus mata kuliah: ' . $e->getMessage(),
            ], 500);
        }
    }
    

    public function getMatakuliahDetail($kodeMK) {

        $matakuliah = JadwalMK::where('kode_mk', $kodeMK)->get();
        
        if ($matakuliah->isEmpty()) {
            return response()->json(['error' => 'Mata kuliah tidak ditemukan'], 404);
        }

        return response()->json($matakuliah);
    }

    public function printHistoriIrs($nim)
    {
        // Ambil data mahasiswa berdasarkan NIM
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
    
        if (!$mahasiswa) {
            return redirect()->back()->withErrors(['message' => 'Mahasiswa tidak ditemukan.']);
        }
    
        // Ambil data IRS yang disetujui, diurutkan berdasarkan tahun ajaran dan semester
        $irsHistori = Irs::where('mahasiswa_id', $mahasiswa->id)
                        ->where('status', 1) // Hanya IRS yang telah disetujui
                        ->orderBy('tahun_akademik', 'asc')
                        ->orderBy('semester', 'asc')
                        ->get();
    
        // Kelompokkan IRS berdasarkan tahun ajaran
        $groupedHistori = $irsHistori->groupBy('tahun_akademik');
    
        $data = [
            'mahasiswa' => $mahasiswa,
            'groupedHistori' => $groupedHistori,
        ];
    
        // Buat PDF
        $pdf = Pdf::loadView('mahasiswa.print-histori-irs', $data);
        return $pdf->stream("Histori_IRS_{$nim}.pdf");
    }

}

