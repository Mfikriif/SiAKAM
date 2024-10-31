<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMk;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    // Fungsi untuk menampilkan halaman jadwal
    public function index()
    {
        // Ambil data mata kuliah dari database
        $mataKuliah = MataKuliah::all();
        $ruangan = Ruangan::all();
        $jadwalList = JadwalMK::all();

        // Kirim data ke view
        return view('kaprodi.listPengajuan', compact('mataKuliah','ruangan','jadwalList'));
    }

    // Fungsi untuk menyimpan jadwal baru
    public function store(Request $request)
    {
        // Memvalidasi Input
        $request->validate([
            'kode_mk' => 'required',
            'nama' => 'required',
            'semester' => 'required|integer',
            'sks' => 'required|integer',
            'sifat' => 'required',
            'pengampu' => 'required',
            'kelas' => 'required',
            'ruangan' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);
    
        // Pengecekan Konflik
        $conflict = DB::table('jadwal_mk')
            ->where('ruangan', $request->ruangan)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($subQuery) use ($request) {
                            $subQuery->where('jam_mulai', '<=', $request->jam_mulai)
                                    ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
            })
            ->exists();
    
        if ($conflict) {
            return redirect()->back()->withErrors(['conflict' => 'Jadwal bentrok! Ruangan sudah terpakai pada waktu tersebut.']);
        }
    
        // Simpan data ke tabel jadwal_mk
        JadwalMk::create([
            'kode_mk' => $request->kode_mk,
            'nama' => $request->nama,
            'semester' => $request->semester,
            'sks' => $request->sks,
            'sifat' => $request->sifat,
            'pengampu' => $request->pengampu,
            'kelas' => $request->kelas,
            'ruangan' => $request->ruangan,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);
    
        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }
    public function destroy($id)
    {
    // Find the record by ID and delete it
    $jadwal = JadwalMk::findOrFail($id);
    $jadwal->delete();

    return redirect()->route('kaprodi.listPengajuan')->with('success', 'Data deleted successfully');
    }
}