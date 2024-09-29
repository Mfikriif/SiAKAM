<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboardDekan(){
        return view('dekan.dashboard');
    }

    public function dashboardAkademik(){
        return view('akademik.dashboard');
    }
    public function dashboardDosenwali(){
        return view('dosenwali.dashboard');
    }
    public function dashboardKaprodi(){
        return view('kaprodi.dashboard');
    }
    public function dashboardMahasiswa(){
        return view('mahasiswa.dashboard');
    }
}
