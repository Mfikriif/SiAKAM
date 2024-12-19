<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Irs;
use App\Models\khs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\TahunAjaran;

class DosenwaliController extends Controller
{
    public function MahasiswaPerwalian(Request $request)
    {
        $dosenWaliId = Auth::user()->id;

        // Ambil data mahasiswa berdasarkan pembimbing akademik
        $query = Mahasiswa::with(['khs' => function ($query) {
            $query->orderBy('semester', 'asc'); // Urutkan data KHS berdasarkan semester
        }])
        ->where('pembimbing_akademik_id', $dosenWaliId)
        ->orderBy('nim', 'asc');

        // Filter berdasarkan angkatan jika ada
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // Pencarian berdasarkan nama atau NIM
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        // Dapatkan data mahasiswa setelah filter dan pencarian
        $mahasiswaPerwalian = $query->get();

        // Ambil data KHS berdasarkan NIM mahasiswa
        foreach ($mahasiswaPerwalian as $mahasiswa) {
            $mahasiswa->khs = Khs::where('nim', $mahasiswa->nim)
                                ->orderBy('semester', 'asc')
                                ->get();
        }

        $user = Auth::user();

        // Kembalikan ke view dengan data mahasiswa perwalian beserta KHS
        return view('dosenwali.listMahasiswaPerwalian', compact('user', 'mahasiswaPerwalian'));
    }

    public function IrsMahasiswaPerwalian(Request $request)
    {
        $dosenWaliId = Auth::user()->id;

        $query = Mahasiswa::where('pembimbing_akademik_id', $dosenWaliId)
                            ->with(['Irs.JadwalMk'])
                            ->orderBy('nim', 'asc');

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            if ($request->status === 'Disetujui') {
                $status = 1;

                $query->whereHas('Irs', function ($q) use ($status) {
                    $q->where('status', $status);
                });
            } elseif ($request->status === 'Belum Disetujui') {
                $status = 0;
    
                $query->where(function ($q) use ($status) {
                    $q->whereDoesntHave('Irs')
                      ->orWhereHas('Irs', function ($q) use ($status) {
                          $q->where('status', $status);
                      });
                });
            }
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // Pencarian berdasarkan nama atau NIM
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        // Dapatkan data mahasiswa setelah filter dan pencarian, termasuk data IRS mereka
        $mahasiswaPerwalian = $query->get();
        $user = Auth::user();

        // Kembalikan ke view dengan data mahasiswa perwalian beserta IRS terkait
        return view('dosenwali.listPengajuanIRS', compact('user', 'mahasiswaPerwalian'));
    }

    public function approveIrsMahasiswa($mahasiswa_id)
    {
        // Ambil data IRS mahasiswa berdasarkan mahasiswa_id dengan status belum disetujui
        $irsList = Irs::where('mahasiswa_id', $mahasiswa_id)->where('status', 0)->get();

        // Periksa apakah mahasiswa memiliki IRS yang bisa disetujui
        if ($irsList->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada IRS yang perlu disetujui untuk mahasiswa ini.');
        }

        // Update semua IRS mahasiswa menjadi disetujui
        foreach ($irsList as $irs) {
            $irs->update([
                'status' => 1,
                'tanggal_persetujuan' => now(), // Menambahkan tanggal persetujuan
            ]);
        }

        return response()->json(['success' => true, 'message' => 'IRS Mahasiswa berhasil disetujui.']);
    }

    public function cancelApproval($mahasiswa_id)
    {
        // Ambil tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('is_active', true)->first();

        if (!$tahunAjaran || !$tahunAjaran->start_date) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun ajaran aktif tidak ditemukan atau tidak memiliki tanggal mulai.'
            ]);
        }

        // Tentukan batas 2 minggu
        $batasDuaMinggu = Carbon::parse($tahunAjaran->start_date)->addDays(14);

        // Ambil semua IRS mahasiswa dengan status disetujui
        $irsList = Irs::where('mahasiswa_id', $mahasiswa_id)
                    ->where('status', 1)
                    ->get();

        if ($irsList->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada IRS yang dapat dibatalkan.');
        }

        foreach ($irsList as $irs) {
            $tanggalPersetujuan = $irs->tanggal_persetujuan;

            // Periksa apakah tanggal persetujuan berada dalam 2 minggu sejak awal semester
            if ($tanggalPersetujuan && $tanggalPersetujuan > $batasDuaMinggu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Persetujuan tidak dapat dibatalkan karena sudah melewati batas 2 minggu.'
                ]);
            }

            // Batalkan persetujuan
            $irs->update([
                'status' => 0,
                'tanggal_persetujuan' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Persetujuan IRS berhasil dibatalkan.'
        ]);
    }

    public function delete($mahasiswaId)
    {
        try {
            // Ambil tahun ajaran aktif
            $tahunAjaran = TahunAjaran::where('is_active', true)->first();

            if (!$tahunAjaran || !$tahunAjaran->start_date) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tahun ajaran aktif tidak ditemukan atau tidak memiliki tanggal mulai.'
                ]);
            }

            // Tentukan batas 4 minggu
            $batasEmpatMinggu = Carbon::parse($tahunAjaran->start_date)->addDays(28);

            // Ambil IRS berdasarkan mahasiswa_id
            $irsList = Irs::where('mahasiswa_id', $mahasiswaId)
                        ->where('status', 1) // Hanya IRS yang sudah disetujui
                        ->get();

            if ($irsList->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada IRS yang dapat dibatalkan.');
            }

            foreach ($irsList as $irs) {
                $tanggalPersetujuan = $irs->tanggal_persetujuan;

                // Periksa apakah tanggal persetujuan berada dalam batas waktu 4 minggu
                if ($tanggalPersetujuan && $tanggalPersetujuan > $batasEmpatMinggu) {
                    return response()->json([
                        'success' => false,
                        'message' => 'IRS tidak dapat dibatalkan karena sudah melewati batas 4 minggu.'
                    ]);
                }

                // Batalkan persetujuan (ubah status menjadi 0)
                $irs->update([
                    'status' => 0,
                    'tanggal_persetujuan' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Persetujuan IRS berhasil dibatalkan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan persetujuan IRS.'
            ]);
        }
    }
    public function rekapMahasiswaPerwalian(Request $request)
    {
        $dosenWaliId = Auth::user()->id;
    
        $query = Mahasiswa::where('pembimbing_akademik_id', $dosenWaliId)
                            ->with(['irs.jadwalMk'])
                            ->orderBy('nim', 'asc');
    
        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            if ($request->status === 'Disetujui') {
                $status = 1;
                $query->whereHas('irs', function ($q) use ($status) {
                    $q->where('status', $status);
                });
            } elseif ($request->status === 'Belum Disetujui') {
                $status = 0;
                $query->where(function ($q) use ($status) {
                    $q->whereDoesntHave('irs')
                      ->orWhereHas('irs', function ($q) use ($status) {
                          $q->where('status', $status);
                      });
                });
            }
        }
    
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }
    
        // Pencarian berdasarkan nama atau NIM
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }
    
        // Ambil data mahasiswa setelah filter
        $mahasiswaPerwalian = $query->get();
    
        // Hitung jumlah mahasiswa yang sudah mengisi IRS dan belum
        $jumlahSudahMengisi = $mahasiswaPerwalian->filter(function ($mahasiswa) {
            return $mahasiswa->irs->isNotEmpty();
        })->count();
    
        $jumlahBelumMengisi = $mahasiswaPerwalian->count() - $jumlahSudahMengisi;
    
        // Ambil nama mahasiswa yang belum mengisi IRS
        $mahasiswaBelumMengisi = $mahasiswaPerwalian->filter(function ($mahasiswa) {
            return $mahasiswa->irs->isEmpty();
        })->pluck('nama');
    
        // Ambil nama mahasiswa yang sudah mengisi IRS
        $mahasiswaSudahMengisi = $mahasiswaPerwalian->filter(function ($mahasiswa) {
            return $mahasiswa->irs->isNotEmpty();
        })->pluck('nama');

        $user = Auth::user();
    
        // Kembalikan ke view dengan data
        return view('dosenwali.rekapMahasiswaPerwalian', compact(
            'user', 
            'mahasiswaPerwalian', 
            'jumlahSudahMengisi', 
            'jumlahBelumMengisi', 
            'mahasiswaBelumMengisi',
            'mahasiswaSudahMengisi'
        ));
    }
    
}