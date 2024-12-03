<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\khs;
use App\Models\MataKuliah;
use App\Models\JadwalMk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class pdfKhsController extends Controller
{
    public function generatePDFKhs($nim)
    {
        $user = Auth::user()->profile_photo;
        

        // Mengambil data mahasiswa 
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        // Mengambil IRS data untuk mahasiswa yang dipilih
        $khsData = khs::where('nim', $nim)->where('semester', $mahasiswa->semester)
            ->get();

        // Mengorganisir data untuk ke view
        $data = [
            'title' => 'Print KHS',
            'date' => date('m/d/Y'),
            'mahasiswa' => $mahasiswa,
            'khsData' => $khsData,
            'image' => Auth::user()->profile_photo, // Mengirimkan data user
        ];

        $pdf = Pdf::loadView('mahasiswa.pdfKHS', $data);

        return $pdf->download('Print KHS.pdf');
    }
}
