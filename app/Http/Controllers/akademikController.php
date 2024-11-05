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
        $user = Auth::user();
        $ruangan = Ruangan::all();
        
        // Kembalikan ke view dengan data mahasiswa perwalian
        return view('akademik.listRuangKuliah', compact('user','ruangan'));
    }
}