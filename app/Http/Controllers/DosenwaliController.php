<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Irs;
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
}