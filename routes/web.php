<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Proyek Semalock mandiri. Halaman utama (/) langsung menampilkan
| Sistem Verifikasi Hak Cipta Gambar Digital (Embed + Verifikasi).
|
*/

Route::get('/', [SiteController::class, 'semalock']);
Route::get('/semalock', [SiteController::class, 'semalock']);
Route::get('/semalock/', [SiteController::class, 'semalock']);
