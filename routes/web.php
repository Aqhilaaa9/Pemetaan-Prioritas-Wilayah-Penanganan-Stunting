<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataStuntingController;
use App\Http\Controllers\HasilDssController;
use App\Http\Controllers\PemetaanController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Tes Route
Route::get('/tes', function () {
    return 'Laravel Berjalan';
});

/*
|--------------------------------------------------------------------------
| FITUR YANG DAPAT DIAKSES OLEH TERAUTENTIKASI (ADMIN & KEPALA DINAS KESEHATAN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pemetaan Stunting
    Route::get('/pemetaan', [PemetaanController::class, 'index'])->name('pemetaan');

    // Analisis DSS
    Route::get('/analisisDSS', [HasilDssController::class, 'index'])->name('analisisDSS');

    // Prioritas Penanganan
    Route::get('/prioritasPenanganan', [HasilDssController::class, 'prioritas'])->name('prioritas');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| FITUR KHUSUS ADMIN (DATA STUNTING & DATA PENGGUNA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // DATA STUNTING (CRUD & IMPORT)
    Route::get('/dataStunting', [DataStuntingController::class, 'index'])->name('dataStunting');
    Route::get('/dataStunting/create', [DataStuntingController::class, 'create'])->name('createStunting');
    Route::post('/dataStunting', [DataStuntingController::class, 'store'])->name('dataStunting.store');
    Route::get('/dataStunting/{dataStunting}/edit', [DataStuntingController::class, 'edit'])->name('editStunting');
    Route::put('/dataStunting/{dataStunting}', [DataStuntingController::class, 'update'])->name('updateStunting');
    Route::delete('/dataStunting/{dataStunting}', [DataStuntingController::class, 'destroy'])->name('deleteStunting');
    Route::get('importStunting', [DataStuntingController::class, 'import'])->name('importStunting');
    Route::post('importStunting', [DataStuntingController::class, 'prosesImport'])->name('importStunting.store');
    Route::get('importStunting/template', [DataStuntingController::class, 'downloadTemplate'])->name('importStunting.template');

    // DATA PENGGUNA (CRUD & VERIFIKASI)
    Route::get('/dataPengguna', [UserController::class, 'index'])->name('dataPengguna');
    Route::get('/dataPengguna/create', [UserController::class, 'create'])->name('createPengguna');
    Route::post('/dataPengguna', [UserController::class, 'store'])->name('dataPengguna.store');
    Route::get('/dataPengguna/{user}/edit', [UserController::class, 'edit'])->name('editPengguna');
    Route::put('/dataPengguna/{user}', [UserController::class, 'update'])->name('updatePengguna');
    Route::delete('/dataPengguna/{user}', [UserController::class, 'destroy'])->name('dataPengguna.destroy');
    Route::post('/dataPengguna/{user}/approve', [UserController::class, 'approve'])->name('dataPengguna.approve');
    Route::post('/dataPengguna/{user}/reject', [UserController::class, 'reject'])->name('dataPengguna.reject');
});

require __DIR__.'/auth.php';

