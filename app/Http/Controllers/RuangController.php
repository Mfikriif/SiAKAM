<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\daftarRuangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RuangController extends Controller
{
    public function buatRuang(Request $request)
    {
        $search = $request->input('search'); 

        // Ambil ruangan dari database
        $daftarRuangan = daftarRuangan::when($search, function ($query, $search) {
            return $query->where('kode_ruangan', 'LIKE', "%{$search}%");
        })
        ->paginate(10); // Menampilkan 10 data per halaman

        $user = Auth::user();

        // Return the view with data ruangan
        if ($request->ajax()) {
            return view('akademik.partialRuang', compact('user','daftarRuangan'))->render();
        }

        return view('akademik.buatRuangKuliah', compact('user', 'daftarRuangan'));
    }

        // Menangani pembuatan ruangan baru
        public function store(Request $request)
        {
            // Validasi Input
            $request->validate([
                'kode_ruangan' => 'required|regex:/^[A-Z][0-9]{3}$/',
                'keterangan' => 'nullable|string',
            ]);
    
            // Pengecekan Konflik
            $kode_ruangan = daftarRuangan::where('kode_ruangan', $request->kode_ruangan)
                ->exists();
        
            // Jika ruangan dengan kode ruangan sudah ada, kembalikan dengan pesan kesalahan
             if ($kode_ruangan) {
                return redirect()->back()->withErrors(['conflict' => 'Kode Ruangan yang dimasukan sudah ada.']);
            }
    
            // Insert each selected room into the `ruangan` table
            daftarRuangan::create([
               'kode_ruangan' => $request->kode_ruangan,
               'keterangan' => $request->keterangan,
            ]);

            return redirect()->back()->with('success', 'Ruangan baru berhasil ditambahkan!');
        }

    // Menghapus data ruangan
    public function destroy($id)
    {
        $ruang = daftarRuangan::findOrFail($id);
        $ruang->delete();

        return redirect()->route('akademik.buatRuangKuliah')->with('success', 'Data berhasil dihapus.');
    }

}