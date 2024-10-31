<?php
namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class akademikController extends Controller
{
    public function Ruangan(Request $request)
    {
        //
        $ruangan = Ruangan::all();
        
        // Kembalikan ke view dengan data mahasiswa perwalian
        return view('akademik.listRuangKuliah', compact('ruangan'));
    }
}