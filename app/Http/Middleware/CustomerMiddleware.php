<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Hanya izinkan akses untuk user dengan role customer.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== UserRole::Customer) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Customer.');
        }

        return $next($request);
    }
}
