<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function herReg()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();

        if (!$mahasiswa) {
            abort(404, 'Mahasiswa tidak ditemukan');
        }

        return view('mahasiswa.herReg', compact('user', 'mahasiswa'));
    }

    public function setAktif($id)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('id', $id)->where('email', $user->email)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        $mahasiswa->status = 1; // Set status ke Aktif
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Status berhasil diubah ke Aktif.');
    }

    public function setCuti($id)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('id', $id)->where('email', $user->email)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        $mahasiswa->status = -1; // Set status ke Cuti
        $mahasiswa->save();

        return redirect()->back()->with('success', 'Status berhasil diubah ke Cuti.');
    }

    public function batalkanStatus($id)
    {
    $user = Auth::user();
    $mahasiswa = Mahasiswa::where('id', $id)->where('email', $user->email)->first();

    if (!$mahasiswa) {
        return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
    }

    $mahasiswa->status = 0; // Reset status ke default (tidak aktif atau cuti)
    $mahasiswa->save();

    return redirect()->back()->with('success', 'Status berhasil dibatalkan.');
    }
}