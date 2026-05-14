<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{LocationController, PetugasController, ProfileController};

Route::get('/', function () {
    return view('welcome');
});

// group admin

Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // routing untuk CRUD petugas.
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
    Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');
    Route::get('/petugas/{param}', [PetugasController::class, 'show'])->name('petugas.show');

    // routing untuk CRUD petugas.
    Route::get('/lokasi', [LocationController::class, 'index'])->name('lokasi.index');
    Route::post('/lokasi', [LocationController::class, 'store'])->name('lokasi.store');
    Route::get('/lokasi/{param}', [LocationController::class, 'show'])->name('lokasi.show');
    Route::post('/lokasi', [LocationController::class, 'store'])->name('lokasi.store');

});

// group petugas

Route::prefix('petugas')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard.petugas');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
