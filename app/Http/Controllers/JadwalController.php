<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMk;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\CivitasAkademik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    // Menampilkan daftar jadwal
    public function index()
    {
        $user = Auth::user();
        $mataKuliah = MataKuliah::all(); // Ambil semua mata kuliah
        $civitasAkademik = CivitasAkademik::all(); // Ambil semua civitas akademik
        $ruangan = Ruangan::all(); // Ambil semua ruangan
        $jadwalList = JadwalMk::all(); // Ambil semua jadwal

        // Menentukan jurusan pengguna
        $isInformatika = $user->civitasAkademik && $user->civitasAkademik->jurusan === 'Informatika';
        $isBioteknologi = $user->civitasAkademik && $user->civitasAkademik->jurusan === 'Bioteknologi';

        // Filter mata kuliah berdasarkan jurusan
        $filteredMataKuliah = $mataKuliah->filter(function($mk) use ($isInformatika, $isBioteknologi) {
            if ($isInformatika) {
                return str_starts_with($mk->kode_mk, 'PAIK');
            } elseif ($isBioteknologi) {
                return str_starts_with($mk->kode_mk, 'LAB') || str_starts_with($mk->kode_mk, 'PAB');
            }
            return true; // Jika bukan Informatika atau Bioteknologi, tampilkan semua
        });

        // Filter civitas akademik berdasarkan jurusan
        $filteredPengampu = $civitasAkademik->filter(function($civitas) use ($isInformatika, $isBioteknologi) {
            if ($isInformatika) {
                return $civitas->jurusan === 'Informatika';
            } elseif ($isBioteknologi) {
                return $civitas->jurusan === 'Bioteknologi';
            }
            return false; // Tidak tampilkan civitas akademik lain
        });

        // Filter jadwal berdasarkan jurusan
        $filteredJadwalList = $jadwalList->filter(function($jadwal) use ($isInformatika, $isBioteknologi) {
            if ($isInformatika) {
                return str_starts_with($jadwal->kode_mk, 'PAIK');
            } elseif ($isBioteknologi) {
                return str_starts_with($jadwal->kode_mk, 'LAB') || str_starts_with($jadwal->kode_mk, 'PAB');
            }
            return false; // Tidak tampilkan jadwal lain
        });

        // Kirim data ke view
        return view('kaprodi.listPengajuan', compact('user', 'mataKuliah', 'filteredMataKuliah', 'filteredPengampu', 'ruangan', 'filteredJadwalList'));
    }

    // Fungsi untuk menyimpan jadwal baru
    public function store(Request $request)
    {
        // Memvalidasi input
        $request->validate([
            'kode_mk' => 'required',
            'nama' => 'required',
            'semester' => 'required|integer',
            'sks' => 'required|integer',
            'sifat' => 'required',
            'kelas' => 'required',
            'ruangan' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'koordinator_mk' => 'required|string',
            'pengampu_1' => 'required|string',
            'pengampu_2' => 'nullable|string',
            'pengampu_3' => 'nullable|string',
        ]);

        // Logika khusus: Membatasi waktu pengajaran (misalnya, tidak boleh di luar jam kerja)
        $jamKerjaMulai = '06:00:00';
        $jamKerjaBerakhir = '18:15:01';

        // Memvalidasi jam mulai dan jam selesai
        if ($request->jam_mulai < $jamKerjaMulai || $request->jam_selesai > $jamKerjaBerakhir) {
            return redirect()->back()->withErrors(['time' => 'Jadwal harus berada di antara jam kerja (06:00 - 18:15).']);
        }

        // Pengecekan konflik jadwal
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

        // Jika terdapat konflik, kembalikan dengan pesan kesalahan
        if ($conflict) {
            return redirect()->back()->withErrors(['conflict' => 'Jadwal bentrok! Ruangan sudah terpakai pada waktu tersebut.']);
        }

        // Pengecekan untuk mencegah duplikasi
        $exists = JadwalMk::where('kode_mk', $request->kode_mk)
            ->where('kelas', $request->kelas)
            ->exists();

        // Jika jadwal dengan kode MK dan kelas yang sama sudah ada, kembalikan dengan pesan kesalahan
        if ($exists) {
            return redirect()->back()->withErrors(['conflict' => 'Jadwal dengan Kode MK dan Kelas ini sudah ada.']);
        }

        // Simpan data ke tabel jadwal_mk
        JadwalMk::create([
            'kode_mk' => $request->kode_mk,
            'nama' => $request->nama,
            'semester' => $request->semester,
            'sks' => $request->sks,
            'sifat' => $request->sifat,
            'kelas' => $request->kelas,
            'ruangan' => $request->ruangan,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'koordinator_mk' => $request->koordinator_mk,
            'pengampu_1' => $request->pengampu_1,
            'pengampu_2' => $request->pengampu_2,
            'pengampu_3' => $request->pengampu_3,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    // Menghapus data jadwal
    public function destroy($id)
    {
        $jadwal = JadwalMk::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('kaprodi.listPengajuan')->with('success', 'Data berhasil dihapus.');
    }

    // Menyetujui jadwal
    public function approve($id)
    {
        $jadwal = JadwalMk::findOrFail($id);
        $jadwal->persetujuan = true;
        $jadwal->save();
        return redirect()->back()->with('success', 'Jadwal berhasil disetujui!');
    }

    // Menolak jadwal
    public function reject($id)
    {
        $jadwal = JadwalMk::findOrFail($id);
        $jadwal->persetujuan = false;
        $jadwal->save();
        return redirect()->back()->with('success', 'Jadwal ditolak.');
    }

    // Menyetujui semua jadwal
    public function approveAll(Request $request)
    {
        // Mengambil semester yang dipilih dari permintaan
        $semester = $request->input('semester');

        // Mengambil program studi dari input tersembunyi
        $program_studi = $request->input('program_studi'); 

        // Menyiapkan query untuk jadwal yang belum disetujui
        $query = JadwalMk::where('persetujuan', false); // Hanya memperbarui yang belum disetujui

        // Menerapkan filter program studi berdasarkan nilai program_studi
        if ($program_studi === 'S1-INFORMATIKA') {
            $query->where('kode_mk', 'like', 'PAIK%');
        } elseif ($program_studi === 'S1-BIOTEKNOLOGI') {
            $query->where(function($subQuery) {
                $subQuery->where('kode_mk', 'like', 'LAB%')
                            ->orWhere('kode_mk', 'like', 'PAB%');
            });
        }

        // Jika semester dipilih, tambahkan kondisi semester ke query
        if ($semester) {
            $query->where('semester', $semester);
        }

        // Eksekusi pembaruan
        $query->update(['persetujuan' => true]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Jadwal berhasil disetujui.');
    }

    // Memperbarui data jadwal
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'kode_mk' => 'required',
            'nama' => 'required',
            'koordinator_mk' => 'required|string',
            'pengampu_1' => 'required',
            'pengampu_2' => 'nullable',
            'pengampu_3' => 'nullable',
            'kelas' => 'required',
            'ruangan' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // Logika khusus: Membatasi waktu pengajaran (tidak boleh di luar jam kerja)
        $jamKerjaMulai = '06:00:00';
        $jamKerjaBerakhir = '18:15:01';

        // Memvalidasi jam mulai dan jam selesai
        if ($request->jam_mulai < $jamKerjaMulai || $request->jam_selesai > $jamKerjaBerakhir) {
            return redirect()->back()->withErrors(['time' => 'Jadwal harus berada di antara jam kerja (06:00 - 18:15).']);
        }

        // Pengecekan konflik jadwal
        $conflict = DB::table('jadwal_mk')
            ->where('id', '!=', $id) // Mengecualikan jadwal yang sedang diperbarui
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

        // Jika terdapat konflik, kembalikan dengan pesan kesalahan
        if ($conflict) {
            return redirect()->back()->withErrors(['conflict' => 'Jadwal bentrok! Ruangan sudah terpakai pada waktu tersebut.']);
        }

        // Pengecekan untuk mencegah duplikasi jadwal
        $exists = JadwalMk::where('id', '!=', $id) // Mengecualikan jadwal yang sedang diperbarui
            ->where('kode_mk', $request->kode_mk)
            ->where('kelas', $request->kelas)
            ->exists();

        // Jika jadwal dengan kode MK dan kelas yang sama sudah ada, kembalikan dengan pesan kesalahan
        if ($exists) {
            return redirect()->back()->withErrors(['conflict' => 'Jadwal dengan Kode MK dan Kelas ini sudah ada.']);
        }

        // Pengecekan untuk mencegah duplikasi pengampu
        $pengampu = array_filter([
            $request->pengampu_1,
            $request->pengampu_2,
            $request->pengampu_3,
        ]); // Menghapus nilai yang tidak diisi (null)

        // Memeriksa apakah ada duplikasi dalam pengampu
        if (count($pengampu) !== count(array_unique($pengampu))) {
            return redirect()->back()->withErrors(['conflict' => 'Pengampu tidak boleh duplikat.']);
        }
    
        // Memperbarui data jadwal
        $jadwal = JadwalMk::findOrFail($id);
        $jadwal->update($request->all());
    
        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui!');
    }
}