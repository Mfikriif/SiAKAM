<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DekanController;
use App\Http\Controllers\MenuController;
use App\Http\Middleware\Dekan;

Route::get('/', function () {
    return view('auth/login');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('dekan/dashboard',[HomeController::class,'dashboardDekan'])->middleware(['auth','dekan']);
Route::get('akademik/dashboard',[HomeController::class,'dashboardAkademik'])->middleware(['auth','akademik']);
Route::get('dosenwali/dashboard',[HomeController::class,'dashboardDosenwali'])->middleware(['auth','dosenwali']);
Route::get('kaprodi/dashboard',[HomeController::class,'dashboardKaprodi'])->middleware(['auth','kaprodi']);
Route::get('mahasiswa/dashboard',[HomeController::class,'dashboardMahasiswa'])->middleware(['auth','mahasiswa']);

Route::get('/select-role', [AuthenticatedSessionController::class, 'showRoleSelection'])->name('role.selection');
Route::post('/select-role', [AuthenticatedSessionController::class, 'selectRole'])->name('role.select');

// controller Dekan
Route::middleware('auth')->group(function() {
    Route::get('dekan/pengajuan-jadwal',[MenuController::class,'PengajuanJadwalDekan'])->name('dekan.listPengajuanJadwal');
    Route::get('dekan/pengajuan-ruang-kuliah',[MenuController::class,'PengajuanRuangKuliahDekan'])->name('dekan.listPengajuanRuang');
});

// controller Dosenwali
Route::get('/pengajuanIRS', function () {
    return view('dosenwali/listPengajuanIRS');
});
Route::get('/mahasiswaPerwalian', function () {
    return view('dosenwali/listMahasiswaPerwalian');
});

// controller Kaprodi
Route::middleware('auth')->group(function() {
    Route::get('kaprodi/pembuatan-jadwal',[MenuController::class,'PengajuanJadwalKaprodi'])->name('kaprodi.listPengajuan');
});
Route::get('/kaprodi/dashboard', [HomeController::class, 'DashboardKaprodi'])->name('kaprodi.dashboard');