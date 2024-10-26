<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DekanController;
use App\Http\Controllers\MenuController;
use App\Http\Middleware\Dekan;
use App\Http\Controllers\DosenWaliController;

Route::get('/', function () {
    return view('auth/login');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Controller untuk Multi Role Users
Route::get('/select-role', [AuthenticatedSessionController::class, 'showRoleSelection'])->name('role.selection');
Route::post('/select-role', [AuthenticatedSessionController::class, 'selectRole'])->name('role.select');

// Controller Mahasiswa Untuk Melindungi Pengaksesan via Link Address
Route::middleware('auth', 'mahasiswa')->group(function() {
    Route::get('mahasiswa/jadwal-kuliah',[MenuController::class,'jadwalKuliah'])->name('mahasiswa.jadwalKuliah');
    Route::get('mahasiswa/herreg',[MenuController::class,'herReg'])->name('mahasiswa.herReg');
    Route::get('mahasiswa/khs',[MenuController::class,'khs'])->name('mahasiswa.khs');
    Route::get('mahasiswa/dashboard',[HomeController::class,'dashboardMahasiswa'])->name('mahasiswa.dashboard');
});

// Controller Akademik untuk Melindungi Pengaksesan via Link Address
Route::middleware('auth', 'akademik')->group(function() {
    Route::get('akademik/dashboard',[HomeController::class,'dashboardAkademik'])->name('akademik.dashboard');
    Route::get('akademik/list-ruang-kuliah',[MenuController::class,'listRuangKuliah'])->name('akademik.listRuangKuliah');
    Route::get('akademik/input-ruang-kuliah',[MenuController::class,'inputRuangKuliah'])->name('akademik.inputRuangKuliah');
});

// Controller Dekan Untuk Melindungi Pengaksesan via Link Address
Route::middleware(['auth', 'dekan'])->group(function() {
    Route::get('dekan/pengajuan-jadwal',[MenuController::class,'PengajuanJadwalDekan'])->name('dekan.listPengajuanJadwal');
    Route::get('dekan/pengajuan-ruang-kuliah',[MenuController::class,'PengajuanRuangKuliahDekan'])->name('dekan.listPengajuanRuang');
    Route::get('dekan/dashboard',[HomeController::class,'dashboardDekan'])->name('dekan.dashboard');
});

// Controller Dosenwali Untuk Melindungi Pengaksesan via Link Address
Route::middleware('auth', 'dosenwali')->group(function () {
    Route::get('dosenwali/pengajuan-irs',[MenuController::class,'PengajuanIrsMahasiswa'])->name('dosenwali.listPengajuanIRS');
    Route::get('dosenwali/mahasiswa-perwalian', [DosenWaliController::class, 'MahasiswaPerwalian'])->name('dosenwali.mahasiswaPerwalian');
    Route::get('dosenwali/dashboard',[HomeController::class,'dashboardDosenwali'])->name('dosenwali.dashboard');
});

// Controller Kaprodi Untuk Melindungi Pengaksesan via Link Address
Route::middleware('auth', 'kaprodi')->group(function() {
    Route::get('kaprodi/pembuatan-jadwal',[MenuController::class,'PengajuanJadwalKaprodi'])->name('kaprodi.listPengajuan');
    Route::get('kaprodi/dashboard',[HomeController::class, 'DashboardKaprodi'])->name('kaprodi.dashboard');    
});


