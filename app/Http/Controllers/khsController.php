<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\khs;
use App\Models\JadwalMk;

class khsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Mencari data mahasiswa berdasarkan email
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();
        
        // Mengambil data KHS mahasiswa berdasarkan nim dan mengelompokkan berdasarkan semester
        $khsMahasiswa = DB::table('khs')
            ->where('nim', $mahasiswa->nim)
            ->get()
            ->groupBy('semester');

        // Menentukan nilai bobot untuk perhitungan IPS/IPK
        $nilai_bobot = [
            'A' => 4,
            'B' => 3,
            'C' => 2,
            'D' => 1,
            'E' => 0,
        ];

        // Variabel untuk menyimpan IPS per semester
        $ipsPerSemester = [];
        $totalBobot = 0;
        $totalSks = 0;

        // Menghitung IPS per semester
        foreach ($khsMahasiswa as $semester => $dataKhs) {
            $semesterBobot = 0;
            $semesterSks = 0;

            // Menghitung total bobot dan total SKS untuk semester ini
            foreach ($dataKhs as $khs) {
                if (!empty($khs->nilai_huruf)) {
                    $bobot = $nilai_bobot[$khs->nilai_huruf] ?? 0;
                    $semesterBobot += $khs->sks * $bobot;
                    $semesterSks += $khs->sks;
                }
            }

            // Menghitung IPS untuk semester ini
            $ips = $semesterSks > 0 ? round($semesterBobot / $semesterSks, 2) : 0;
            $ipsPerSemester[$semester] = $ips;

            // Menghitung total bobot dan total SKS untuk IPK
            $totalBobot += $semesterBobot;
            $totalSks += $semesterSks;
        }

        // Menghitung IPK
        $ipk = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;

        // Mengirimkan data ke view

        return view('mahasiswa.khs', [
            'user' => $user,
            'khsMahasiswa' => $khsMahasiswa,
            'ipsPerSemester' => $ipsPerSemester,
            'ipk' => $ipk,
        ], compact('user', 'mahasiswa', 'khsMahasiswa'));
    }
}
