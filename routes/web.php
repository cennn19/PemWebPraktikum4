<?php

use App\Http\Controllers\BeritaController;
use Illuminate\Support\Facades\Route;

// Mengarahkan pengunjung ke daftar berita dan menghubungkan halaman detail serta form komentar.
Route::redirect('/', '/berita');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
Route::post('/berita/{berita}/komentar', [BeritaController::class, 'komentar'])->name('berita.komentar');