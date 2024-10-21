<?php 
    // app/Http/Controllers/Mahasiswa/DashboardController.php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.dashboard', compact('mahasiswa'));
    }
}

// Buat controller serupa untuk role lainnya
?>