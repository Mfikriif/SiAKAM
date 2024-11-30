<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMk;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\CivitasAkademik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MatkulController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isInformatika = $user->civitasAkademik && $user->civitasAkademik->jurusan === 'Informatika';
        $isBioteknologi = $user->civitasAkademik && $user->civitasAkademik->jurusan === 'Bioteknologi';
    
        // Filter mata kuliah berdasarkan jurusan dengan pagination
        $filteredMataKuliah = MataKuliah::where(function ($query) use ($isInformatika, $isBioteknologi) {
            if ($isInformatika) {
                $query->where('kode_mk', 'like', 'PAIK%');
            } elseif ($isBioteknologi) {
                $query->where('kode_mk', 'like', 'LAB%')
                      ->orWhere('kode_mk', 'like', 'PAB%');
            }
        })->paginate(10);
    
        if ($request->ajax()) {
            return view('kaprodi.partialMataKuliah', compact('filteredMataKuliah'))->render();
        }
    
        // Filter jadwal berdasarkan jurusan dengan pagination
        $filteredJadwalList = JadwalMk::where(function ($query) use ($isInformatika, $isBioteknologi) {
            if ($isInformatika) {
                $query->where('kode_mk', 'like', 'PAIK%');
            } elseif ($isBioteknologi) {
                $query->where('kode_mk', 'like', 'LAB%')
                      ->orWhere('kode_mk', 'like', 'PAB%');
            }
        })->paginate(10);
    
        return view('kaprodi.pembuatanMk', compact('user', 'filteredMataKuliah', 'filteredJadwalList'));
    }

    // Fungsi untuk menyimpan Matkul baru
    public function store(Request $request)
    {
        $user = Auth::user();
        // Memvalidasi input
        $request->validate([
            'kode_mk' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    // Cek apakah jurusan Informatika
                    if ($user->civitasAkademik && $user->civitasAkademik->jurusan === 'Informatika') {
                        if (!str_starts_with($value, 'PAIK')) {
                            $fail('Kode MK untuk jurusan Informatika harus diawali dengan "PAIK".');
                        }
                    }
    
                    // Cek apakah jurusan Bioteknologi
                    if ($user->civitasAkademik && $user->civitasAkademik->jurusan === 'Bioteknologi') {
                        if (!(str_starts_with($value, 'PAB') || str_starts_with($value, 'LAB'))) {
                            $fail('Kode MK untuk jurusan Bioteknologi harus diawali dengan "PAB" atau "LAB".');
                        }
                    }
                }
            ],
            'nama_mk' => 'required',
            'semester' => 'required|integer|min:0',
            'sks' => 'required|integer|min:0',
            'sifat' => 'required',
        ]);

        // Pengecekan untuk mencegah duplikasi
        $kodemk = MataKuliah::where('kode_mk', $request->kode_mk)
            ->exists();
        // Jika jadwal dengan kode MK dan kelas yang sama sudah ada, kembalikan dengan pesan kesalahan
        if ($kodemk) {
            return redirect()->back()->withErrors(['conflict' => 'Kode MK yang dimasukan sudah ada.']);
        }

        // Pengecekan untuk mencegah duplikasi
        $namamk = MataKuliah::where('nama_mk', $request->nama_mk)
        ->exists();
        // Jika jadwal dengan kode MK dan kelas yang sama sudah ada, kembalikan dengan pesan kesalahan
        if ($namamk) {
            return redirect()->back()->withErrors(['conflict' => 'Nama MK yang dimasukan sudah ada.']);
        }
        
        // Simpan data ke tabel jadwal_mk
        MataKuliah::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'semester' => $request->semester,
            'sks' => $request->sks,
            'sifat' => $request->sifat,
        ]);

        return redirect()->back()->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }

    // Menghapus data mata kuliah
    public function destroy($kode_mk)
    {
        $mk = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();
        $mk->delete();

        return redirect()->route('kaprodi.pembuatanMk')->with('success', 'Data berhasil dihapus.');
    }


    // Fungsi untuk menyimpan jadwal baru
    public function update(Request $request, $kode_mk)
    {
        $user = Auth::user();
        // Memvalidasi input
        $request->validate([
            'kode_mk' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    // Cek apakah jurusan Informatika
                    if ($user->civitasAkademik && $user->civitasAkademik->jurusan === 'Informatika') {
                        if (!str_starts_with($value, 'PAIK')) {
                            $fail('Kode MK untuk jurusan Informatika harus diawali dengan "PAIK".');
                        }
                    }
    
                    // Cek apakah jurusan Bioteknologi
                    if ($user->civitasAkademik && $user->civitasAkademik->jurusan === 'Bioteknologi') {
                        if (!(str_starts_with($value, 'PAB') || str_starts_with($value, 'LAB'))) {
                            $fail('Kode MK untuk jurusan Bioteknologi harus diawali dengan "PAB" atau "LAB".');
                        }
                    }
                }
            ],
            'nama_mk' => 'required',
            'semester' => 'required|integer',
            'sks' => 'required|integer',
            'sifat' => 'required',
        ]);


        // Pengecekan untuk mencegah duplikasi Nama MK hanya jika nama_mk berubah
        if ($request->nama_mk !== MataKuliah::findOrFail($kode_mk)->nama_mk) {
            $existingMatkul = MataKuliah::where('nama_mk', $request->nama_mk)
                ->where('kode_mk', '!=', $kode_mk) // Pastikan kode MK tidak diperiksa untuk duplikasi
                ->exists();

            // Jika ada duplikasi Nama MK, kembalikan dengan pesan kesalahan
            if ($existingMatkul) {
                return redirect()->back()->withErrors(['conflict' => 'Nama MK yang dimasukkan sudah ada.']);
            }
        }

        // Memperbarui data jadwal dan mengatur persetujuan ke 0
        $matkul = MataKuliah::findOrFail($kode_mk);
        $matkul->nama_mk = $request->nama_mk;
        $matkul->semester = $request->semester;
        $matkul->sks = $request->sks;
        $matkul->sifat = $request->sifat;
        $matkul->save();

        return redirect()->back()->with('success', 'Mata Kuliah berhasil diupdate!');
    }
}
