<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{ItemController, LocationController, PetugasController, ProfileController};

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

    // routing untuk CRUD Lokasi.
    Route::get('/lokasi', [LocationController::class, 'index'])->name('lokasi.index');
    Route::post('/lokasi', [LocationController::class, 'store'])->name('lokasi.store');
    Route::get('/lokasi/{param}', [LocationController::class, 'show'])->name('lokasi.show');
    Route::put('/lokasi/{param}', [LocationController::class, 'update'])->name('lokasi.update');
    Route::delete('/lokasi/{param}', [LocationController::class, 'destroy'])->name('lokasi.destroy');

    // routing untuk CRUD barang.
    Route::get('/barang', [ItemController::class, 'index'])->name('barang.index');
    Route::post('/barang', [ItemController::class, 'store'])->name('barang.store');
    Route::get('/barang/{param}', [ItemController::class, 'show'])->name('barang.show');
    Route::put('/barang/{param}', [ItemController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{param}', [ItemController::class, 'destroy'])->name('barang.destroy');

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
