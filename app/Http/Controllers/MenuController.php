<?php 
namespace App\Http\Controllers;


class MenuController extends Controller
{
    // Controller Mahasiswa
    public function jadwalKuliah()
    {
        return view('mahasiswa.jadwalKuliah');
    }

    public function herReg()
    {
        return view('mahasiswa.herReg');
    }

    public function khs()
    {
        return view('mahasiswa.khs');
    }
    // Controlle Dekan
    public function pengajuanJadwalDekan()
    {
        return view('dekan.listPengajuanJadwal');
    }

    public function pengajuanRuangKuliahDekan()
    {
        return view('dekan.listPengajuanJadwal');
    }
    // end Controller Dekan

    // Controller Kaprodi
    public function pengajuanJadwalKaprodi(){
        return view('kaprodi.listPengajuan');
    }

    // Controller Dosen Wali
    public function pengajuanIrsMahasiswa()
    {
        return view('dosenwali.listPengajuanIRS');
    }
    
    public function mahasiswaPerwalian()
    {
        return view('dosenwali.listMahasiswaPerwalian');
    }
    // end Controller Dosen Wali

}
?>