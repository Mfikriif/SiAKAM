<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\khs;
use App\Models\JadwalMk;

class KhsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Mencari data mahasiswa berdasarkan email
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();
        
        // Mengambil data KHS mahasiswa berdasarkan nim dan mengelompokkan berdasarkan semester
        $khsMahasiswa = DB::table('khs')
        ->where('nim',$mahasiswa->nim)
        ->get()
        ->groupBy('semester')
        ;
        // dd($khsMahasiswa);

        // Mengirimkan data ke view
        return view('mahasiswa.khs', [
            'user' => $user,
            'khsMahasiswa' => $khsMahasiswa, // Pastikan data dikirim ke view
        ]);
    }
}
