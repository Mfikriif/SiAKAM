<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class akademikController extends Controller
{
    public function Ruangan(Request $request)
    {
        // Ambil input pencarian
        $search = $request->input('search'); 

        // Ambil ruangan dari database
        $ruangan = Ruangan::select('jurusan')
        ->when($search, function ($query, $search) {
            return $query->where('jurusan', 'LIKE', "%{$search}%");
        })
        ->groupBy('jurusan')
        ->get();

        foreach($ruangan as $prodi){
            $prodi->ruang = Ruangan::where('jurusan', $prodi->jurusan)->get();

        }

        // Ambil kode_ruangan yang sudah dipilih
        $kodeRuanganSelected = Ruangan::pluck('kode_ruangan')->toArray();


        // Return the view with data ruangan
        return view('akademik.listRuangKuliah', compact('ruangan', 'kodeRuanganSelected'));
    }

    public function store(Request $request) 
    {
        // Validasi input
        $request->validate([
            'jurusan' => 'required|string',
            'kapasitas' => 'required|integer',
            'kode_ruangan' => 'required',
        ]);    
        
        // Pengecekan Konflik
        foreach ($request->kode_ruangan as $kode) {
            $conflict = DB::table('ruangan')
                ->where('kode_ruangan', $kode)
                ->where('jurusan', '<>', $request->jurusan) // Exclude the current department
                ->exists();

            if ($conflict) {
                return redirect()->back()->withErrors(['conflict' => "Ruangan bentrok! Ruangan $kode sudah digunakan prodi lain."]);
            }
        }

        // Insert each selected room into the `ruangan` table
        foreach ($request->kode_ruangan as $kode) {
            Ruangan::create([
                'kode_ruangan' => $kode,
                'jurusan' => $request->jurusan,
                'kapasitas' => $request->kapasitas,
            ]);
        }

        return redirect()->route('akademik.listRuangKuliah')->with('success', 'Ruangan have been successfully added!');
    }

    public function inputRuangKuliah()
    {
        // Ambil data mata nama dari database
        $user = Auth::user();

        // Ambil data ruangan dari tabel daftar_ruangan
        $daftarRuangan = DB::table('daftar_ruangan')->get();

        $kodeRuanganSelected = Ruangan::pluck('kode_ruangan')->toArray();

        // Kirim data ke view
        return view('akademik.inputRuangKuliah', compact('user', 'daftarRuangan', 'kodeRuanganSelected'));
    }

    // Ruangan Ditolak
    public function rejectRuangan($id, Request $request){
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->persetujuan = -1; // Rejected
        $ruangan->save();

        return response()->json(['success' => true, 'reason' => $ruangan->reason_for_rejection]);
    }
    
    // Hapus Ruangan
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();
        return redirect()->route('akademik.listRuangKuliah')->with('success', 'Data berhasil dihapus.');
    }
}
