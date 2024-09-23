<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/mahasiswa', function () {
    return view('dashboard_mahasiswa');
});

Route::get('/dosenwali', function () {
    return view('dashboard_dosenwali');
});

Route::get('/kaprodi', function () {
    return view('dashboard_kaprodi');
});

Route::get('/akademik', function () {
    return view('dashboard_akademik');
});

Route::get('/dekan', function () {
    return view('dashboard_dekan');
});


require __DIR__.'/auth.php';

route::get('dekan/dashboard',[HomeController::class,'dashboardDekan'])->middleware(['auth','dekan']);
route::get('akademik/dashboard',[HomeController::class,'dashboardAkademik'])->middleware(['auth','akademik']);
route::get('dosenwali/dashboard',[HomeController::class,'dashboardDosenwali'])->middleware(['auth','dosenwali']);
route::get('kaprodi/dashboard',[HomeController::class,'dashboardKaprodi'])->middleware(['auth','kaprodi']);
route::get('user/dashboard',[HomeController::class,'dashboardUser'])->middleware(['auth','user']);