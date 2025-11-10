<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeluargaKkController;
use App\Http\Controllers\LoginController;
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
| Resource admin
|--------------------------------------------------------------------------
*/
Route::resource('user', UserController::class);

Route::resource('warga', WargaController::class);
//keluarga kk
Route::resource('keluarga-kk', KeluargaKkController::class);

Route::prefix('admin')->name('pages.admin.')->group(function () {
    // URL: /admin/keluarga-kk
    // Name: pages.admin.keluarga_kk.*
    Route::resource('keluarga-kk', KeluargaKKController::class)->names('keluarga_kk');
});

Route::prefix('admin')->name('pages.admin.')->group(function () {
    Route::resource('keluarga-kk', KeluargaKKController::class)->names('keluarga_kk');
});

//warga
Route::prefix('admin')->name('pages.admin.')->group(function () {
    // Menampilkan semua warga
    Route::get('warga', [WargaController::class, 'index'])->name('warga.index');

    // Menampilkan form tambah warga
    Route::get('warga/create', [WargaController::class, 'create'])->name('warga.create');

    // Menyimpan data warga baru
    Route::post('warga', [WargaController::class, 'store'])->name('warga.store');

    // Menampilkan detail warga
    Route::get('warga/{id}', [WargaController::class, 'show'])->name('warga.show');

    // Menampilkan form edit warga
    Route::get('warga/{id}/edit', [WargaController::class, 'edit'])->name('warga.edit');

    // Mengupdate data warga
    Route::put('warga/{id}', [WargaController::class, 'update'])->name('warga.update');

    // Menghapus data warga
    Route::delete('warga/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');
});

