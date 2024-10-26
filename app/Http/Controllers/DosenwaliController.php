<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenWaliController extends Controller
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
        
        // Kembalikan ke view dengan data mahasiswa perwalian
        return view('dosenwali.listMahasiswaPerwalian', compact('mahasiswaPerwalian'));
    }
}