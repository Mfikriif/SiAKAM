<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\CivitasAkademik;
use App\Models\JadwalMk;


class HomeController extends Controller
{

    public function dashboardAkademik()
    {
        $user = Auth::user();
        $akademik = CivitasAkademik::where('email', $user->email)->firstOrFail();
        return view('akademik.dashboard', [
            'user' => $user,
            'userName' => $akademik->nama,
            'userNIP' => $akademik->nip,
            'userEmail' => $akademik->email,
            'nomorHP' => $akademik->no_hp,
            'jurusan' => $akademik->jurusan
        ]);
    }

    public function dashboardDosenwali()
    {
        $user = Auth::user();
        $dosenwali = CivitasAkademik::where('email', $user->email)->firstOrFail();
        return view('dosenwali.dashboard', [
            'user' => $user,
            'userName' => $dosenwali->nama,
            'userNIP' => $dosenwali->nip,
            'userEmail' => $dosenwali->email,
            'nomorHP' => $dosenwali->no_hp,
            'jurusan' => $dosenwali->jurusan
        ]);
    }

    public function dashboardKaprodi()
    {
    $user = Auth::user();
    $kaprodi = CivitasAkademik::where('email', $user->email)->firstOrFail();
    $totalMahasiswa = Mahasiswa::where('jurusan', 'like', '%' . $kaprodi->jurusan . '%')->count();
    $totalDosen = User::where('role', '6' or '3')->count();
    $rerataIPK = 3.51;

    return view('kaprodi.dashboard', [
        'user' => $user,
        'userName' => $kaprodi->nama,
        'userNIP' => $kaprodi->nip,
        'userEmail' => $kaprodi->email,
        'nomorHP' => $kaprodi->no_hp,
        'jurusan' => $kaprodi->jurusan,
        'totalMahasiswa' => $totalMahasiswa,
        'totalDosen' => $totalDosen,
        'rerataIPK' => $rerataIPK
        ]);
    }

    public function dashboardMahasiswa()
    {
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