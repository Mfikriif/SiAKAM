<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMk;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\TahunAjaran;
use App\Models\CivitasAkademik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    // Menampilkan daftar jadwal
    public function index(Request $request)
    {
        $user = Auth::user();
        $mataKuliah = MataKuliah::all();
        $civitasAkademik = CivitasAkademik::all();
        $jadwalList = JadwalMk::all();

        // Menentukan jurusan pengguna
        $isInformatika = $user->civitasAkademik && $user->civitasAkademik->jurusan === 'Informatika';
        $isBioteknologi = $user->civitasAkademik && $user->civitasAkademik->jurusan === 'Bioteknologi';

        // Cari tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        // Pastikan tahun ajaran aktif ada
        if (!$tahunAjaranAktif) {
            return redirect()->back()->withErrors(['tahun_ajaran' => 'Tidak ada tahun ajaran yang aktif!']);
        }

        // Tentukan apakah semester aktif adalah Ganjil atau Genap
        $isSemesterGanjil = $tahunAjaranAktif->semester === 'Ganjil';

        // Filter mata kuliah berdasarkan jurusan dan semester (ganjil/genap)
        $filteredMataKuliah = $mataKuliah->filter(function ($mk) use ($isInformatika, $isBioteknologi, $isSemesterGanjil) {
            // Ambil angka kedua dari kode mata kuliah
            $isKodeGanjil = (int) substr($mk->kode_mk, 5, 1) % 2 === 1;

            // Filter berdasarkan jurusan dan semester
            if ($isInformatika) {
                return str_starts_with($mk->kode_mk, 'PAIK') && ($isSemesterGanjil ? $isKodeGanjil : !$isKodeGanjil);
            } elseif ($isBioteknologi) {
                return (str_starts_with($mk->kode_mk, 'LAB') || str_starts_with($mk->kode_mk, 'PAB')) && ($isSemesterGanjil ? $isKodeGanjil : !$isKodeGanjil);
            }
            return true; // Tampilkan semua mata kuliah untuk jurusan lain
        });

        // Filter civitas akademik berdasarkan jurusan
        $filteredPengampu = $civitasAkademik->filter(function ($civitas) use ($isInformatika, $isBioteknologi) {
            if ($isInformatika) {
                return $civitas->jurusan === 'Informatika';
            } elseif ($isBioteknologi) {
                return $civitas->jurusan === 'Bioteknologi';
            }
            return false;
        });

        // Filter jadwal berdasarkan jurusan
        $filteredJadwalList = JadwalMk::where(function ($query) use ($isInformatika, $isBioteknologi) {
            if ($isInformatika) {
                $query->where('kode_mk', 'like', 'PAIK%');
            } elseif ($isBioteknologi) {
                $query->where('kode_mk', 'like', 'LAB%')
                    ->orWhere('kode_mk', 'like', 'PAB%');
            }
        })->paginate(10);

        // Filter ruangan berdasarkan jurusan dan persetujuan
        $ruangan = Ruangan::where('jurusan', $user->civitasAkademik->jurusan)
                        ->where('persetujuan', 1)
                        ->get();

        // Jika request berasal dari AJAX, hanya kembalikan partial view untuk jadwal
        if ($request->ajax()) {
            return view('kaprodi.partialJadwal', compact('filteredJadwalList', 'filteredPengampu','filteredMataKuliah','ruangan'))->render();
        }

        // Kirim semua data ke view utama
        return view('kaprodi.listPengajuan', compact(
            'user', 'mataKuliah', 'filteredMataKuliah', 'filteredPengampu', 'ruangan', 'filteredJadwalList'
        ));
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
            'kelas_custom' => 'nullable|string|max:50',
            'kuota_kelas' => 'required|integer|min:0',
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
        $jamKerjaMulai = '05:59:59';
        $jamKerjaBerakhir = '18:15:01';

        // Memvalidasi jam mulai dan jam selesai
        if (
            strtotime($request->jam_mulai) < strtotime($jamKerjaMulai) || 
            strtotime($request->jam_mulai) >= strtotime($jamKerjaBerakhir) ||
            strtotime($request->jam_selesai) <= strtotime($jamKerjaMulai) || 
            strtotime($request->jam_selesai) > strtotime($jamKerjaBerakhir)
        ) {
            return redirect()->back()->withErrors(['time' => 'Jadwal harus berada di antara jam kerja (06:00 - 18:15).']);
        }

        // Pengecekan konflik kuota kelas dengan kapasitas ruangan
        $ruangan = Ruangan::where('kode_ruangan', $request->ruangan)->first();
        if ($ruangan && $request->kuota_kelas > $ruangan->kapasitas) {
            return redirect()->back()->withErrors(['conflict' => 'Kuota kelas melebihi kapasitas ruangan!']);
        }

        // Pengecekan konflik ruangan
        $ruanganConflict = DB::table('jadwal_mk')
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
        if ($ruanganConflict) {
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

        // Pengecekan untuk mencegah irisan jadwal matakuliah wajib
        $irisan = JadwalMk::where('semester', $request->semester)
            ->where('kelas', $request->kelas)
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
        if ($irisan) {
            return redirect()->back()->withErrors(['conflict' => 'Jadwal bentrok dengan Mata Kuliah Wajib yang lain! ']);
        }
        // Cari tahun ajaran yang aktif
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        // Jika tidak ada tahun ajaran aktif, kembalikan dengan pesan kesalahan
        if (!$tahunAjaranAktif) {
            return redirect()->back()->withErrors(['tahun_ajaran' => 'Tidak ada tahun ajaran yang aktif!']);
        }

        $kelas = $request->kelas === 'Other' ? $request->kelas_custom : $request->kelas;
        // Simpan data ke tabel jadwal_mk
        JadwalMk::create([
            'kode_mk' => $request->kode_mk,
            'nama' => $request->nama,
            'semester' => $request->semester,
            'sks' => $request->sks,
            'sifat' => $request->sifat,
            'kelas' => $request->kelas,
            'kuota_kelas' => $request->kuota_kelas,
            'ruangan' => $request->ruangan,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'koordinator_mk' => $request->koordinator_mk,
            'pengampu_1' => $request->pengampu_1,
            'pengampu_2' => $request->pengampu_2,
            'pengampu_3' => $request->pengampu_3,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
        ]);

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
    public function approveJadwal($id)
    {
        $jadwal = JadwalMk::findOrFail($id);
        $jadwal->persetujuan = 1;
        $jadwal->reason_for_rejection = null;
        $jadwal->save();

        return response()->json(['success' => true, 'message' => 'Jadwal telah disetujui.']);
    }

    // Menolak jadwal
    public function rejectJadwal($id, Request $request)
    {
        $jadwal = JadwalMk::findOrFail($id);
        $jadwal->persetujuan = -1;
        $jadwal->reason_for_rejection = $request->input('reason');
        $jadwal->save();
    
        return response()->json(['success' => true, 'reason' => $jadwal->reason_for_rejection]);
    }

    // Membatalkan persetujuan
    public function cancelApproval($id, Request $request)
    {
        $jadwal = JadwalMk::findOrFail($id);
        $jadwal->persetujuan = 0;
        $jadwal->reason_for_rejection = null;
        $jadwal->save();

        return response()->json(['success' => true, 'message' => 'Persetujuan telah dibatalkan.']);
    }

    // Menyetujui semua jadwal
    public function approveAll(Request $request)
    {
        try {
            $semester = $request->input('semester');
            $jurusan = strtolower($request->input('jurusan'));

            // Query Persetujuan
            $query = JadwalMK::where('persetujuan', 0);
            if ($semester) {
                $query->where('semester', $semester);
            }

            if ($jurusan) {
                if ($jurusan === 'informatika') {
                    $query->where('kode_mk', 'like', 'PAIK%');
                } elseif ($jurusan === 'bioteknologi') {
                    $query->where(function($subQuery) {
                        $subQuery->where('kode_mk', 'like', 'LAB%')
                                ->orWhere('kode_mk', 'like', 'PAB%');
                    });
                }
            }
            $updatedRows = $query->update(['persetujuan' => 1]);

            return response()->json([
                'success' => true,
                'message' => "Approved all requests for $jurusan, semester $semester.",
                'updated_count' => $updatedRows,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in approveAll: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error.']);
        }
    }

    // Memperbarui data jadwal
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'semester' => 'required|integer',
            'kode_mk' => 'required',
            'nama' => 'required',
            'koordinator_mk' => 'required|string',
            'pengampu_1' => 'required|string',
            'pengampu_2' => 'nullable|string',
            'pengampu_3' => 'nullable|string',
            'kuota_kelas' => 'required|integer|min:0',
            'ruangan' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);
    
        // Logika khusus: Membatasi waktu pengajaran (tidak boleh di luar jam kerja)
        $jamKerjaMulai = '06:00:00';
        $jamKerjaBerakhir = '18:15:00';
        if ($request->jam_mulai < $jamKerjaMulai || $request->jam_selesai > $jamKerjaBerakhir) {
            return redirect()->back()->withErrors(['time' => 'Jadwal harus berada di antara jam kerja (06:00 - 18:15).']);
        }

        // Pengecekan konflik kuota kelas dengan kapasitas ruangan
        $ruangan = Ruangan::where('kode_ruangan', $request->ruangan)->first();
        if ($ruangan && $request->kuota_kelas > $ruangan->kapasitas) {
            return redirect()->back()->withErrors(['conflict' => 'Kuota kelas melebihi kapasitas ruangan!']);
        }
    
        // Pengecekan konflik jadwal
        $conflict = DB::table('jadwal_mk')
            ->where('id', '!=', $id)
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
    
        // Pengecekan untuk mencegah duplikasi jadwal
        $exists = JadwalMk::where('id', '!=', $id) // Mengecualikan jadwal yang sedang diperbarui
            ->where('kode_mk', $request->kode_mk)
            ->where('kelas', $request->kelas)
            ->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['conflict' => 'Jadwal dengan Kode MK dan Kelas ini sudah ada.']);
        }
        
        // Pengecekan untuk mencegah irisan jadwal matakuliah wajib
        $irisan = JadwalMk::where('id', '!=', $id)
            ->where('semester', $request->semester)
            ->where('kelas', $request->kelas)
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
        if ($irisan) {
            return redirect()->back()->withErrors(['conflict' => 'Jadwal bentrok dengan Mata Kuliah Wajib yang lain! ']);
        }

        // Pengecekan untuk mencegah duplikasi pengampu
        $pengampu = array_filter([
            $request->pengampu_1,
            $request->pengampu_2,
            $request->pengampu_3,
        ]);
        if (count($pengampu) !== count(array_unique($pengampu))) {
            return redirect()->back()->withErrors(['conflict' => 'Pengampu tidak boleh duplikat.']);
        }
    
        // Memperbarui data jadwal dan mengatur persetujuan ke 0
        $jadwal = JadwalMk::findOrFail($id);
        $jadwal->kode_mk = $request->kode_mk;
        $jadwal->semester = $request->semester;
        $jadwal->nama = $request->nama;
        $jadwal->koordinator_mk = $request->koordinator_mk;
        $jadwal->pengampu_1 = $request->pengampu_1;
        $jadwal->pengampu_2 = $request->pengampu_2;
        $jadwal->pengampu_3 = $request->pengampu_3;
        $jadwal->kuota_kelas = $request->kuota_kelas;
        $jadwal->ruangan = $request->ruangan;
        $jadwal->hari = $request->hari;
        $jadwal->jam_mulai = $request->jam_mulai;
        $jadwal->jam_selesai = $request->jam_selesai;
        $jadwal->persetujuan = 0;
        $jadwal->save();
        
        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui dan menunggu persetujuan.');
    }
}