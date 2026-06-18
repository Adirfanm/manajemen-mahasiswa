<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class)
        ->parameters([
            'mahasiswa' => 'nim',
        ])
        ->except(['show']);
});

require __DIR__.'/settings.php';
