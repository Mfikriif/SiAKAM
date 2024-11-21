<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CivitasAkademik;
use App\Models\JadwalMk;
use App\Models\Mahasiswa;
use App\Models\User;

class DekanController extends Controller
{
    // Method to display the dashboard for the dekan (Dean)
    public function dashboardDekan()
    {
        $user = Auth::user();
        $dekan = CivitasAkademik::where('email', $user->email)->firstOrFail();
        $pendingPengajuanCount = JadwalMK::where('persetujuan', 0)->count();
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = User::where('role', '6' or '3')->count();
        $rerataIPK = 3.51;

        return view('dekan.dashboard', [
            'user' => $user,
            'userName' => $dekan->nama,
            'userNIP' => $dekan->nip,
            'userEmail' => $dekan->email,
            'nomorHP' => $dekan->no_hp,
            'jurusan' => $dekan->jurusan,
            'pendingPengajuanCount' => $pendingPengajuanCount,
            'totalMahasiswa' => $totalMahasiswa,
            'totalDosen' => $totalDosen,
            'rerataIPK' => $rerataIPK
        ]);
    }

    public function listPengajuanJadwal()
    {
        // Retrieve all room requests, regardless of 'persetujuan' status
        $user = Auth::user();
        $jadwalList = jadwalMK::paginate(10);
    
        return view('dekan.listPengajuanJadwal', compact('user','jadwalList'));
    }
    
    public function listPengajuanRuang()
    {
        // Retrieve all room requests, regardless of 'persetujuan' status
        $user = Auth::user();
        $ruanganList = Ruangan::paginate(10);
    
        return view('dekan.listPengajuanRuang', compact('user','ruanganList'));
    }

    public function approve($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->persetujuan = 1; // 1 berarti disetujui
        $ruangan->save();
    
        return response()->json(['success' => true, 'status' => 'Disetujui']);
    }

    public function reject($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->persetujuan = -1; // 1 berarti disetujui
        $ruangan->save();
    
        return response()->json(['success' => true, 'status' => 'Ditolak']);
    }

    public function cancelReject($id)
    {
        try {
            $ruang = Ruangan::findOrFail($id);
            $ruang->persetujuan = 0; // Set to 0 to indicate "Belum Disetujui"
            $ruang->save();

            return response()->json([
                'success' => true,
                'status' => 'Belum Disetujui',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in cancelReject: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error.']);
        }
    }


    public function approveAll(Request $request)
    {
        $jurusan = $request->jurusan;
    
        // Query to select only entries that are pending approval (persetujuan = 0)
        $query = Ruangan::where('persetujuan', 0); // Only select entries that are pending
    
        // Apply additional filter if a specific jurusan is provided
        if ($jurusan) {
            $query->where('jurusan', $jurusan);
        }
    
        // Perform the update: this will only affect rows where persetujuan is 0
        $updatedCount = $query->update(['persetujuan' => 1]);
    
        return response()->json([
            'success' => true,
            'updated' => $updatedCount,
            'message' => $updatedCount > 0 ? 'All pending requests approved successfully.' : 'No pending requests were found for approval.'
        ]);
    }
    
    public function changeStatus($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->persetujuan = 0; // Set ke Belum Disetujui
        $ruangan->save();
    
        return response()->json(['success' => true, 'status' => 'Belum Disetujui']);
    }
}