<?php
use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeluargaKKController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeristiwaKelahiranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Default redirect
|--------------------------------------------------------------------------
*/
// Arahkan root ke halaman login
Route::get('/', [LoginController::class, 'index'])->name('login.index');

/*
|--------------------------------------------------------------------------
| Auth (Login/Register/Logout)
|--------------------------------------------------------------------------
*/
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::get('/register/success', function () {
    return redirect()->route('login.index')
        ->with('success', 'Registrasi berhasil. Silakan login.');
})->name('register.success');

Route::get('/register/error', function () {
    return redirect()->route('register.index')
        ->with('error', 'Terjadi kesalahan! Silakan ulang kembali.');
})->name('register.error');

Route::get('/register', [LoginController::class, 'registerForm'])->name('register.index');
Route::post('/register', [LoginController::class, 'register'])->name('register.process');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard (setelah login)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Resource admin (Non-admin prefix) - Dibiarkan sesuai kode awal Anda
|--------------------------------------------------------------------------
*/
Route::resource('user', UserController::class);
Route::resource('warga', WargaController::class);
Route::resource('keluarga-kk', KeluargaKKController::class);

/*
|--------------------------------------------------------------------------
| Resource admin (dengan prefix 'admin') - Semua rute disatukan di sini
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('pages.admin.')->group(function () {

    // Warga (Rute eksplisit Anda)
    Route::get('warga', [WargaController::class, 'index'])->name('warga.index');
    Route::get('warga/create', [WargaController::class, 'create'])->name('warga.create');
    Route::post('warga', [WargaController::class, 'store'])->name('warga.store');
    Route::get('warga/{id}', [WargaController::class, 'show'])->name('warga.show');
    Route::get('warga/{id}/edit', [WargaController::class, 'edit'])->name('warga.edit');
    Route::put('warga/{id}', [WargaController::class, 'update'])->name('warga.update');
    Route::delete('warga/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');

    Route::resource('keluarga-kk', KeluargaKKController::class)->names('keluarga_kk');

        // --- ANGGOTA KELUARGA (TAMBAHKAN) ---
    Route::resource('anggota_keluarga', AnggotaKeluargaController::class);

    // --- PERISTIWA KELAHIRAN (TAMBAHKAN) ---
    Route::resource('peristiwa_kelahiran', PeristiwaKelahiranController::class);

});
