<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute situs (portfolio + PassCreator)
|--------------------------------------------------------------------------
| TANPA prefix studyflow. Dimuat PALING AKHIR di bootstrap/app.php agar
| fallback di bawah tidak menelan rute StudyFlow (/studyflow/*), API,
| maupun cron yang sudah didaftarkan sebelumnya.
|
| URL kanonis:
|   /home               -> portfolio (termasuk Tic Tac Toe)
|   /home/passcreator   -> PassCreator (Enkripsi/Dekripsi, murni di browser)
| URL lama diarahkan 301 ke kanonis, bukan 404, supaya bookmark lama tetap jalan.
| Jalur lain yang tidak cocok -> 404 situs (favicon T) via SiteController::notFound.
| Jalur /studyflow/* yang tidak cocok -> 404 StudyFlow via routes/pages.php.
*/

Route::get('/home', [SiteController::class, 'home']);
// /home/ HARUS dilayani langsung, bukan diarahkan ke /home:
// /home adalah folder beneran, Apache mengalihkan /home -> /home/,
// jadi arah balik dari Laravel akan loop. Lihat StripTrailingSlash::isSitePath.
Route::get('/home/', [SiteController::class, 'home']);
Route::get('/home/passcreator', [SiteController::class, 'passcreator']);
Route::get('/home/passcreator/', [SiteController::class, 'passcreator']);

// URL lama (file statis dulu): arahkan ke rute Laravel, jangan biarkan 404.
Route::get('/home/index.html', fn () => redirect('/home', 301));
Route::get('/home/PassCreator.html', fn () => redirect('/home/passcreator', 301));
Route::get('/home/passcreator.html', fn () => redirect('/home/passcreator', 301));
Route::get('/home/PassCreator', fn () => redirect('/home/passcreator', 301));
Route::get('/passcreator', fn () => redirect('/home/passcreator', 301));
Route::get('/passcreator/', fn () => redirect('/home/passcreator', 301));

// Semalock — verifikasi hak cipta gambar digital (watermark QR terenkripsi)
Route::get('/semalock', [SiteController::class, 'semalock']);
Route::get('/semalock/', [SiteController::class, 'semalock']);

// Statistik kunjungan (dilindungi token di URL, lihat VisitStatsController)
// dan opt-out pemilik. Bukan halaman konten, jadi tidak dicatat VisitLogger.
Route::get('/kunjungan', [\App\Http\Controllers\VisitStatsController::class, 'stats']);
Route::get('/jangan-hitung-saya', [\App\Http\Controllers\VisitStatsController::class, 'optOut']);
Route::get('/hitung-saya-lagi', [\App\Http\Controllers\VisitStatsController::class, 'optIn']);

// Harus paling akhir di file ini (dan file ini dimuat paling akhir).
Route::fallback([SiteController::class, 'notFound']);
