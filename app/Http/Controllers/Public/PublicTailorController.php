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
            ->withCount('portfolios')
            ->withAvg('reviewsReceived', 'rating')
            ->withCount('reviewsReceived')
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

        // Muat ulasan terbaru beserta nama customer
        $reviews = $tailor->reviewsReceived()
            ->with('customer:id,name')
            ->latest()
            ->paginate(5, ['*'], 'review_page');

        $avgRating     = $tailor->reviewsReceived()->avg('rating');
        $reviewCount   = $tailor->reviewsReceived()->count();
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $tailor->reviewsReceived()->where('rating', $i)->count();
            $ratingBreakdown[$i] = [
                'count'   => $count,
                'percent' => $reviewCount > 0 ? round($count / $reviewCount * 100) : 0,
            ];
        }

        return view('public.tailors.show', compact('tailor', 'reviews', 'avgRating', 'reviewCount', 'ratingBreakdown'));
    }
}
