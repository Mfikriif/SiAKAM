<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\CivitasAkademik;


class HomeController extends Controller
{
    public function dashboardDekan()
    {
        $user = Auth::user();
        return view('dekan.dashboard', [
            'userName' => $user->name,
            'userNIP' => $user->nip,
            'userEmail' => $user->email,
            'nomorHP' => $user->no_hp,
            'jurusan' => $user->jurusan
        ]);
    }

    public function dashboardAkademik()
    {
        $user = Auth::user();
        return view('akademik.dashboard', [
            'userName' => $user->name,
            'userNIP' => $user->nip,
            'userEmail' => $user->email,
            'nomorHP' => $user->no_hp,
            'jurusan' => $user->jurusan
        ]);
    }

    public function dashboardDosenwali()
    {
        $user = Auth::user();
        return view('dosenwali.dashboard', [
            'userName' => $user->name,
            'userNIP' => $user->nip,
            'userEmail' => $user->email,
            'nomorHP' => $user->no_hp,
            'jurusan' => $user->jurusan
        ]);
    }

    public function dashboardKaprodi()
    {
        $user = Auth::user();
        return view('kaprodi.dashboard', [
            'userName' => $user->name,
            'userNIP' => $user->nip,
            'userEmail' => $user->email,
            'nomorHP' => $user->no_hp,
            'jurusan' => $user->jurusan
        ]);
    }

    public function dashboardMahasiswa()
    {
        // Retrieve Mahasiswa data
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->firstOrFail();
        $doswal = CivitasAkademik::where('id', $mahasiswa->pembimbing_akademik_id)->first();


        return view('mahasiswa.dashboard', [
            'user' => $user,
            'userName' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'jurusan' => $mahasiswa->jurusan,
            'nomorHP' => $mahasiswa->no_hp,
            'namaDoswal' => $doswal->nama ?? 'N/A',
            'nipDoswal' => $doswal->nip ?? 'N/A'
        ]);
    }
}