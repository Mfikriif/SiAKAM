<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\akademikController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DekanController;
use App\Http\Controllers\MenuController;
use App\Http\Middleware\Dekan;
use App\Http\Controllers\DosenWaliController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\IrsController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\khsController;
use App\Http\Controllers\pdfKhsController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
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
    Route::get('/mahasiswa/jadwal-kuliah',[MahasiswaController::class,'jadwalMahasiswa'])->name('mahasiswa.jadwalKuliah');
    Route::get('mahasiswa/herreg',[MahasiswaController::class,'herReg'])->name('mahasiswa.herReg');
    Route::post('/mahasiswa/{id}/set-aktif', [MahasiswaController::class, 'setAktif'])->name('mahasiswa.setAktif');
    Route::post('/mahasiswa/{id}/set-cuti', [MahasiswaController::class, 'setCuti'])->name('mahasiswa.setCuti');
    Route::post('/mahasiswa/{id}/batalkan-status', [MahasiswaController::class, 'batalkanStatus'])->name('mahasiswa.batalkanStatus');
    Route::get('mahasiswa/menu-khs',[MenuController::class,'khs'])->name('mahasiswa.khs');
    Route::get('mahasiswa/khs',[khsController::class,'index'])->name('mahasiswa.khs');
    Route::get('mahasiswa/dashboard',[HomeController::class,'dashboardMahasiswa'])->name('mahasiswa.dashboard');
    Route::get('mahasiswa/irs',[IrsController::class, 'index'])->name('mahasiswa.irs');
    Route::post('/mahasiswa/irs/store',[irsController::class,'store'])->name('irs.store');  
    Route::delete('/mahasiswa/irs/delete',[irsController::class,'delete'])->name('irs.delete');
    Route::post('/mahasiswa/listMk',[irsController::class,'searchMk'])->name('irs.searchMk');
    Route::get('/get-matakuliah-detail/{kodeMK}', [irsController::class, 'getMatakuliahDetail']);
    Route::get('/print-irs/{mahasiswaId}', [PDFController::class, 'generatePDF'])->name('irs.print');
    Route::get('/print-khs/{nim}', [pdfKhsController::class, 'generatePDFKhs'])->name('khs.print');

});

// Controller Akademik untuk Melindungi Pengaksesan via Link Address
Route::middleware('auth', 'akademik')->group(function() {
    Route::get('akademik/dashboard',[HomeController::class,'dashboardAkademik'])->name('akademik.dashboard');
    Route::post('/Ruangan/store', [akademikController::class, 'store'])->name('Ruangan.store');
    Route::get('akademik/input-ruang-kuliah', [akademikController::class, 'inputRuangKuliah'])->name('akademik.inputRuangKuliah');
    Route::get('akademik/list-ruang-kuliah',[akademikController::class,'Ruangan'])->name('akademik.listRuangKuliah');
    Route::get('akademik/buat-ruang',[RuangController::class,'buatRuang'])->name('akademik.buatRuangKuliah');
    Route::post('/ruang/store',[RuangController::class,'store'])->name('ruang.store');
    Route::delete('/ruang/{id}',[RuangController::class,'destroy'])->name('ruang.destroy');
    Route::get('/api/ruang', [RuangController::class, 'getAllRuang'])->name('ruang.getAll');
    Route::delete('/Ruangan/{id}', [akademikController::class, 'destroy'])->name('Ruangan.destroy');
    Route::put('/Ruangan/{id}', [akademikController::class, 'update'])->name('Ruangan.update');
});

// Controller Dekan Untuk Melindungi Pengaksesan via Link Address
Route::middleware(['auth', 'dekan'])->group(function() {
    Route::get('dekan/pengajuan-jadwal',[DekanController::class,'listPengajuanJadwal'])->name('dekan.listPengajuanJadwal');
    Route::get('/dekan/list-pengajuan-ruang', [DekanController::class, 'listPengajuanRuang'])->name('dekan.listPengajuanRuang');
    Route::post('/dekan/list-pengajuan-ruang/approve-all', [DekanController::class, 'approveAll'])->name('dekan.approveAll');
    Route::post('/dekan/approve-ruang/{id}', [DekanController::class, 'approve'])->name('approve.ruang');
    Route::post('/dekan/reject-ruang/{id}', [DekanController::class, 'reject'])->name('reject.ruang');
    Route::post('/dekan/cancel-reject-ruang/{id}', [DekanController::class, 'cancelReject'])->name('dekan.cancelReject');
    Route::post('/dekan/change-status-ruang/{id}', [DekanController::class, 'changeStatus'])->name('change.status.ruang');
    Route::get('dekan/dashboard',[DekanController::class,'dashboardDekan'])->name('dekan.dashboard');
    Route::post('/jadwal/approve/{id}', [JadwalController::class, 'approveJadwal'])->name('jadwal.approve');
    Route::post('/jadwal/reject/{id}', [JadwalController::class, 'rejectJadwal'])->name('jadwal.reject');
    Route::post('/jadwal/approve-all', [JadwalController::class, 'approveAll'])->name('jadwal.approveAll');
    Route::post('/jadwal/cancel/{id}', [JadwalController::class, 'cancelApproval'])->name('jadwal.cancel');
});

// Controller Dosenwali Untuk Melindungi Pengaksesan via Link Address
Route::middleware('auth', 'dosenwali')->group(function () {
    Route::get('dosenwali/pengajuan-irs',[DosenwaliController::class,'IrsMahasiswaPerwalian'])->name('dosenwali.listPengajuanIRS');
    Route::get('dosenwali/mahasiswa-perwalian', [DosenWaliController::class, 'MahasiswaPerwalian'])->name('dosenwali.mahasiswaPerwalian');
    Route::get('dosenwali/dashboard',[HomeController::class,'dashboardDosenwali'])->name('dosenwali.dashboard');
    Route::post('/dosenwali/approve-irs/{mahasiswa_id}', [DosenWaliController::class, 'approveIrsMahasiswa'])->name('dosenwali.approveIrsMahasiswa');
    Route::post('/dosenwali/cancel-approval/{mahasiswa_id}', [DosenWaliController::class, 'cancelApproval'])->name('dosenwali.cancelApproval');
});

// Controller Kaprodi Untuk Melindungi Pengaksesan via Link Address
Route::middleware('auth', 'kaprodi')->group(function() {
    Route::get('kaprodi/dashboard',[HomeController::class, 'DashboardKaprodi'])->name('kaprodi.dashboard');
    Route::get('kaprodi/pembuatan-jadwal',[JadwalController::class, 'index'])->name('kaprodi.listPengajuan');
    Route::get('kaprodi/pembuatan-mk',[MatkulController::class, 'index'])->name('kaprodi.pembuatanMk');
    Route::post('/matkul/store', [MatkulController::class, 'store'])->name('matkul.store');
    Route::put('/matkul/update/{kode_mk}', [MatkulController::class, 'update'])->name('matkul.update');
    Route::delete('/matkul/{kode_mk}', [MatkulController::class, 'destroy'])->name('matkul.destroy');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::put('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::get('/jadwal/ruangan/{ruangan?}', [JadwalController::class, 'getRuanganTerpakai'])->name('jadwal.ruangan');
});


Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});