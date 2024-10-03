<?php 
namespace App\Http\Controllers;


class MenuController extends Controller
{
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