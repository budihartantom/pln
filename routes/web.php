<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\GarduController;
use App\Http\Controllers\PengukuranController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\RankingTopsisController;
use App\Http\Controllers\LaporanTopsisController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('kriteria', KriteriaController::class);
        Route::resource('users', UserController::class);
    });

    // Operator & Admin
    Route::middleware(['role:admin,operator'])->group(function () {
        Route::resource('gardu', GarduController::class);
        Route::resource('pengukuran', PengukuranController::class);
        
        Route::get('/perhitungan', [TopsisController::class, 'index'])->name('topsis.index');
        Route::post('/perhitungan', [TopsisController::class, 'calculate'])->name('topsis.calculate');
        Route::get('/riwayat', [TopsisController::class, 'history'])->name('topsis.history');
        Route::get('/riwayat/{run}', [TopsisController::class, 'show'])->name('topsis.show');
    });

    // Manager, Operator, Admin
    Route::middleware(['role:admin,operator,manager'])->group(function () {
        Route::prefix('topsis')->name('topsis.')->group(function () {
            Route::get('/perhitungan', [TopsisController::class, 'index'])->name('perhitungan.index');
            Route::get('/ranking-prioritas', [RankingTopsisController::class, 'index'])->name('ranking.index');
            Route::get('/laporan', [LaporanTopsisController::class, 'index'])->name('laporan.index');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
