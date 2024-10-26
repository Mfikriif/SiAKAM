<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Dosenwali;
use App\Models\Akademik;
use App\Models\Dekan;
use App\Models\Kaprodi;

class HomeController extends Controller
{
    public function dashboardDekan(){
        $user = Auth::user();
        $dekan = Dekan::where('email', $user->email)->first();
        $userName = $user->name;
        $userNIP = $dekan->nip;
        $userEmail = $user->email;
        $nomorHP = $dekan->no_hp;
        $jurusan = $dekan->jurusan;
        return view('dekan.dashboard',compact('userName','userNIP','userEmail','nomorHP','jurusan'));
    }

    public function dashboardAkademik(){
        $user = Auth::user();
        $akademik = Akademik::where('email', $user->email)->first();
        $userName = $user->name;
        $userNIP = $akademik->nip;
        $userEmail = $user->email;
        $nomorHP = $akademik->no_hp;
        $jurusan = $akademik->jurusan;
        return view('akademik.dashboard',compact('userName','userNIP','userEmail','nomorHP','jurusan'));
    }

    public function dashboardDosenwali(){
        $user = Auth::user();
        $dosenwali = Dosenwali::where('email', $user->email)->first();
        $userName = $user->name;
        $userNIP = $dosenwali->nip;
        $userEmail = $user->email;
        $nomorHP = $dosenwali->no_hp;
        $jurusan = $dosenwali->jurusan;
        return view('dosenwali.dashboard',compact('userName','userNIP','userEmail','nomorHP','jurusan'));
    }

    public function dashboardKaprodi(){
        $user = Auth::user();
        $kaprodi = Kaprodi::where('email', $user->email)->first();
        $userName = $user->name;
        $userNIP = $kaprodi->nip;
        $userEmail = $user->email;
        $nomorHP = $kaprodi->no_hp;
        $jurusan = $kaprodi->jurusan;
        return view('kaprodi.dashboard',compact('userName','userNIP','userEmail','nomorHP','jurusan'));
    }

    public function dashboardMahasiswa(){
        //Pengambilan Data DB Mahasiswa 
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();
        $userName = $mahasiswa->name;
        $nim = $mahasiswa->nim;
        $jurusan = $mahasiswa->jurusan;
        $nomorHP = $mahasiswa->no_hp;

        //Pengambilan Data DB Pembimbing Akademik
        $doswal = $mahasiswa->dosenwali;
        $namaDoswal =  $doswal->nama;
        $nipDoswal = $doswal->nip;
        return view('mahasiswa.dashboard', compact('user','userName','nim','jurusan','nomorHP','namaDoswal','nipDoswal'));

    }
}

