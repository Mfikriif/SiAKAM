<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Irs;
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

    public function jadwalMahasiswa()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('id', $user->id)->where('email', $user->email)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        // Ambil IRS yang sudah disetujui dan jadwal mata kuliah yang terkait
        $jadwalList = Irs::where('mahasiswa_id', $mahasiswa->id)
                        ->where('status', '1')
                        ->with('jadwalMK')
                        ->get()
                        ->sortBy(function ($item) {
                            $order = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                            return array_search($item->jadwalMK->hari, $order);
                        });
        
        $totalSksAmbil = Irs::where('mahasiswa_id', $mahasiswa->id)->sum('sks');
        
        return view('mahasiswa.jadwalKuliah', compact('user', 'jadwalList', 'totalSksAmbil'));
    }
}