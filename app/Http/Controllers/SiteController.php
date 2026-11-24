<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Halaman situs (bukan StudyFlow): portfolio /home, PassCreator, Semalock, dan 404 global.
 */
class SiteController
{
    public function home(Request $request)
    {
        return response()
            ->view('home', ['cspNonce' => $this->nonce($request)])
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    public function passcreator(Request $request)
    {
        return response()
            ->view('passcreator', ['cspNonce' => $this->nonce($request)])
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    public function semalock(Request $request)
    {
        return response()
            ->view('semalock', ['cspNonce' => $this->nonce($request)])
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * 404 situs — dipakai sebagai fallback global (lihat routes/site.php).
     * Rute StudyFlow (/studyflow/*) yang tidak cocok ditangani fallback
     * terpisah di routes/pages.php, jadi tidak sampai ke sini.
     */
    public function notFound(Request $request): Response
    {
        $path = '/' . ltrim($request->path(), '/');
        $accept = (string) $request->header('Accept', '');

        if (str_starts_with($path, '/api/') || str_contains($accept, 'application/json')) {
            return response()->json([
                'message' => 'Alamat tidak ditemukan.',
                'error' => 'Not Found',
                'statusCode' => 404,
            ], 404, [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return response()
            ->view('site404', ['cspNonce' => $this->nonce($request)])
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->setStatusCode(404);
    }

    /** CSP nonce pada request ini. */
    private function nonce(Request $request): string
    {
        $nonce = $request->attributes->get('csp_nonce');

        return is_string($nonce) && $nonce !== '' ? $nonce : '';
    }
}
