<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Irs;
use App\Models\khs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Ambil semua IRS mahasiswa dengan status disetujui
        $irsList = Irs::where('mahasiswa_id', $mahasiswa_id)->where('status', 1)->get();

        if ($irsList->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada IRS yang dapat dibatalkan.');
        }

        // Ubah status semua IRS menjadi belum disetujui (status = 0)
        foreach ($irsList as $irs) {
            $irs->update([
                'status' => 0,
                'tanggal_persetujuan' => null,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Persetujuan IRS Mahasiswa berhasil dibatalkan.']);
    }

    public function delete($mahasiswaId)
    {
        try {
            // Hapus data IRS
            $irs = Irs::where('mahasiswa_id', $mahasiswaId)->first();
            if ($irs) {
                $irs->delete();
            }
    
            // Ubah status mahasiswa menjadi -1 (cuti)
            $herreg = Mahasiswa::find($mahasiswaId);
            if ($herreg) {
                $herreg->status = -1; // Set status cuti
                $herreg->save();
            } else {
                return response()->json(['success' => false, 'message' => 'Mahasiswa tidak ditemukan.']);
            }
    
            return response()->json(['success' => true, 'message' => 'IRS berhasil dibatalkan dan status mahasiswa diubah menjadi cuti (-1).']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat membatalkan IRS.']);
        }
    }
}