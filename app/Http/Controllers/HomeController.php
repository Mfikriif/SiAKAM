<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\CivitasAkademik;
use App\Models\JadwalMk;
use App\Models\Irs;
use App\Models\khs;
use Illuminate\Support\Facades\DB;


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
        
        $statusIrs = Irs::where('nim', $mahasiswa->nim)
        ->where('semester',$mahasiswa->semester)
        ->first();

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

        $ipkMhs = $totalSks > 0 ? round($totalBobot / $totalSks, 2) : 0;

        // Mengambil total sks yang sudah diambil selama perkuliahan
        $totalSks = khs::where('nim',$mahasiswa->nim)->sum('sks');

    if ($statusIrs) {
        if ($statusIrs->status == 1) {
            $statusNotif = 'Irs anda telah disetujui';
        } elseif ($statusIrs->status == 0) {
            $statusNotif = 'Irs anda belum disetujui';
        } else {
            $statusNotif = null; // Tidak menampilkan apapun
        }
    } else {
        $statusNotif = null; // Tidak menampilkan apapun jika data tidak ditemukan
    }

        return view('mahasiswa.dashboard', [
            'user' => $user,
            'userName' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'jurusan' => $mahasiswa->jurusan,
            'nomorHP' => $mahasiswa->no_hp,
            'namaDoswal' => $doswal->nama ?? 'N/A',
            'nipDoswal' => $doswal->nip ?? 'N/A',
            'statusAktif' => $mahasiswa,
            'ipk' => $ipkMhs,
            'sks' => $totalSks,
        ],compact('statusNotif'));
    }
}