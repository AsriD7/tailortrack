<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Hanya izinkan akses untuk user dengan role admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== UserRole::Admin) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Admin.');
        }

        return $next($request);
    }
}
