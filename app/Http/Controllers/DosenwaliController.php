<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenwaliController extends Controller
{
    public function MahasiswaPerwalian(Request $request)
    {
        $dosenWaliId = Auth::user()->id;
        // Ambil data mahasiswa berdasarkan pembimbing akademik
        $query = Mahasiswa::where('pembimbing_akademik_id', $dosenWaliId);
    
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
        $user = Auth::user();
        // Kembalikan ke view dengan data mahasiswa perwalian
        return view('dosenwali.listMahasiswaPerwalian', compact('user','mahasiswaPerwalian'));
    }

    public function IrsMahasiswaPerwalian(Request $request)
    {
        $dosenWaliId = Auth::user()->id;

        // Ambil data mahasiswa berdasarkan pembimbing akademik, beserta data IRS mereka
        $query = Mahasiswa::where('pembimbing_akademik_id', $dosenWaliId)
                            ->with(['Irs.JadwalMk']); // Memuat data IRS terkait untuk setiap mahasiswa

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

        // Dapatkan data mahasiswa setelah filter dan pencarian, termasuk data IRS mereka
        $mahasiswaPerwalian = $query->get();
        $user = Auth::user();

        // Kembalikan ke view dengan data mahasiswa perwalian beserta IRS terkait
        return view('dosenwali.listPengajuanIRS', compact('user', 'mahasiswaPerwalian'));
    }

    public function approveIrs(request $request)
    {
        try {
            // Mengambil semua IRS dengan status belum disetujui (status = 0)
            $query = Irs::where('status', 0)
                        ->with(['Mahasiswa', 'JadwalMk']);
    
            // Perbarui status menjadi 1 (disetujui) dan tambahkan tanggal persetujuan
            $query->update([
                'status' => 1, // Disetujui
                'tanggal_persetujuan' => now(), // Set waktu persetujuan
            ]);
    
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Semua IRS berhasil disetujui.');
        } catch (\Exception $e) {
            // Tangani error jika ada
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}