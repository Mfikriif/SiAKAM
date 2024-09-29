<?php 
namespace App\Http\Controllers;

use Illuminate\Auth\Access;

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

    
}
?>