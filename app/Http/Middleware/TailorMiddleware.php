<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TailorMiddleware
{
    /**
     * Hanya izinkan akses untuk user dengan role tailor (penjahit).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== UserRole::Tailor) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Penjahit.');
        }

        return $next($request);
    }
}
