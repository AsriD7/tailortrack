<?php

namespace App\Http\Controllers\Public;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;

class PublicTailorController extends Controller
{
    /**
     * Tampilkan daftar penjahit yang sudah terverifikasi dan tersedia.
     */
    public function index()
    {
        $tailors = User::where('role', UserRole::Tailor->value)
            ->whereHas('tailorProfile', fn($q) => $q->where('is_verified', true)->where('is_available', true))
            ->with(['tailorProfile', 'portfolios'])
            ->paginate(12);

        return view('public.tailors.index', compact('tailors'));
    }

    /**
     * Tampilkan profil lengkap penjahit beserta portofolio.
     */
    public function show(User $tailor)
    {
        // Pastikan user yang diminta adalah penjahit yang valid
        abort_if(
            $tailor->role !== UserRole::Tailor || !$tailor->tailorProfile?->is_verified,
            404,
            'Penjahit tidak ditemukan.'
        );

        $tailor->load(['tailorProfile', 'portfolios']);

        return view('public.tailors.show', compact('tailor'));
    }
}
