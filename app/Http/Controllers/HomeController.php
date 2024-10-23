<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboardDekan(){
        $user = auth()->user();
        $userName = $user->name;
        $userEmail = $user->email;

        return view('dekan.dashboard',compact('userName','userEmail'));
    }

    public function dashboardAkademik(){

        $user = auth()->user();
        $userName = $user->name;
        $userEmail = $user->email;

        return view('akademik.dashboard',compact('userName','userEmail'));
    }
    public function dashboardDosenwali(){

        $user = auth()->user();
        $userName = $user->name;
        $userEmail = $user->email;

        return view('dosenwali.dashboard',compact('userName','userEmail'));
    }
    public function dashboardKaprodi(){

        $user = auth()->user();
        $userName = $user->name;
        $userEmail = $user->email;

        return view('kaprodi.dashboard',compact('userName','userEmail'));
    }
    public function dashboardMahasiswa(){

        $user = auth()->user();
        $userName = $user->name;
        $userEmail = $user->email;

        return view('mahasiswa.dashboard',compact('userName','userEmail'));
    }
}

