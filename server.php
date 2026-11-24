<?php

/**
 * Router localhost untuk StudyFlow (PHP built-in server).
 *
 * Di produksi (hosting Apache), perilaku URL ditentukan oleh tiga berkas
 * .htaccess + DirectoryIndex:
 *   public/.htaccess           : / -> /home/ (301); /home* & /passcreator* ->
 *                                front controller Laravel; dan fallback situs.
 *   public/studyflow/.htaccess : /studyflow/* (non-berkas) -> Laravel.
 *
 * Berkas ini dipakai OTOMATIS oleh `php artisan serve` — ServeCommand memeriksa
 * base_path('server.php') lebih dulu, dan HANYA memakai router bawaan framework
 * kalau berkas ini tidak ada. Router bawaan itu memotong permintaan apa pun yang
 * cocok dengan berkas/direktori nyata di public/ (return false), yang membuat:
 *   /home        -> dilayani sebagai direktori (404, tak ada index.html)
 *   /studyflow/  -> diambil public/studyflow/index.php yang `$root`-nya
 *                   masih hard-code untuk hosting (fatal 500 di localhost).
 *
 * Berkas ini meniru aturan .htaccess persis, lalu mengarahkan semua rute lewat
 * front controller asli public/index.php (yang sudah menormalisasi SCRIPT_NAME
 * agar /studyflow/* tidak terpotong base URL-nya).
 *
 * Jalankan dengan:
 *   php artisan serve
 *
 * Perintah lama  `php -S 127.0.0.1:8000 -t public server.local.php`  tetap bisa:
 * server.local.php hanyalah shim yang meneruskan ke berkas ini.
 */

declare(strict_types=1);

$publicPath = __DIR__ . '/public';
$uri = urldecode((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// File statis nyata (mis. favicon, /semalock/jsQR.js): biarkan built-in server layani.
if ($uri !== '/' && is_file($publicPath . $uri)) {
    return false;
}

// Sisanya lewat front controller Laravel.
require $publicPath . '/index.php';