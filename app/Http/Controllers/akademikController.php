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
        // Retrieve all rooms from the database
        $ruangan = Ruangan::select('jurusan', DB::raw('GROUP_CONCAT(kode_ruangan SEPARATOR ", ") as kode_ruangan'), 'kapasitas')
        ->groupBy('jurusan', 'kapasitas')
        ->get();
        
        // Return the view with the room data
        return view('akademik.listRuangKuliah', compact('ruangan'));
    }

    public function store(Request $request) 
    {
        // Validate input
        $request->validate([
            'jurusan' => 'required|string',
            'kapasitas' => 'required|integer',
            'kode_ruangan' => 'required',
        ]);    
        
        // Check for conflicts with each selected room
        foreach ($request->kode_ruangan as $kode) {
            $conflict = DB::table('ruangan')
                ->where('kode_ruangan', $kode)
                ->where('jurusan', '<>', $request->jurusan) // Exclude the current department
                ->exists();

            if ($conflict) {
                return redirect()->back()->withErrors(['conflict' => "Conflict! Room $kode is already in use by another department."]);
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

        return redirect()->route('akademik.listRuangKuliah')->with('success', 'Rooms have been successfully added!');
    }

    public function inputRuangKuliah()
    {
        // Ambil data mata nama dari database

        // Kirim data ke view
        return view('akademik.inputRuangKuliah');
    }

    // Memperbarui data ruangan
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $request->validate([
            'jurusan' => 'required|string',
            'kapasitas' => 'required|integer',
            'kode_ruangan' => 'required',
        ]);   

        // Pengecekan untuk mencegah duplikasi ruangan
        $exists = Ruangan::where('id', '!=', $id) // Mengecualikan ruangan yang sedang diperbarui
            ->where('kode_ruangan', $request->kode_mk)
            ->where('jurusan', $request->kelas)
            ->exists();

        // Jika ruangan dengan kode ruangan dan jurusan yang sama sudah ada, kembalikan dengan pesan kesalahan
        if ($exists) {
            return redirect()->back()->withErrors(['conflict' => 'Ruangan dengan Kode Ruangan dan Jurusan ini sudah ada.']);
        }

    
        // Memperbarui data jadwal  
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($request->all());
    
        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui!');
    }
}
