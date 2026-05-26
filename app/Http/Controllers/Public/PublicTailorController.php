<?php

namespace App\Http\Controllers\Public;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\PriceList;
use App\Models\TailorProfile;
use App\Models\User;
use Illuminate\Http\Request;

class PublicTailorController extends Controller
{
    /**
     * Tampilkan daftar penjahit yang sudah terverifikasi dan tersedia.
     */
    public function index(Request $request)
    {
        $serviceSkills = PriceList::whereHas('tailors', function ($q) {
                $q->where('role', UserRole::Tailor->value)
                    ->whereHas('tailorProfile', fn($profile) => $profile->where('is_verified', true)->where('is_available', true));
            })
            ->orderBy('category')
            ->orderBy('name')
            ->pluck('name');

        $profileSkills = TailorProfile::where('is_verified', true)
            ->where('is_available', true)
            ->whereNotNull('specialization')
            ->pluck('specialization')
            ->flatMap(function ($specialization) {
                return collect(explode(',', $specialization))
                    ->map(fn($skill) => trim($skill))
                    ->filter();
            });

        $skillOptions = $serviceSkills
            ->merge($profileSkills)
            ->unique(fn($skill) => mb_strtolower($skill))
            ->sort()
            ->values();

        $query = User::where('role', UserRole::Tailor->value)
            ->whereHas('tailorProfile', fn($q) => $q->where('is_verified', true)->where('is_available', true))
            ->with(['tailorProfile', 'portfolios'])
            ->withCount('portfolios')
            ->withCount('tailorOrders')
            ->withAvg('reviewsReceived', 'rating')
            ->withCount('reviewsReceived');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('priceLists', function ($priceList) use ($search) {
                        $priceList->where('name', 'like', "%{$search}%")
                            ->orWhere('category', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tailorProfile', function ($profile) use ($search) {
                        $profile->where('shop_name', 'like', "%{$search}%")
                            ->orWhere('specialization', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('skill')) {
            $skill = $request->skill;

            $query->where(function ($q) use ($skill) {
                $q->whereHas('priceLists', function ($priceList) use ($skill) {
                    $priceList->where('name', 'like', "%{$skill}%")
                        ->orWhere('category', 'like', "%{$skill}%")
                        ->orWhere('description', 'like', "%{$skill}%");
                })
                ->orWhereHas('tailorProfile', function ($profile) use ($skill) {
                    $profile->where('specialization', 'like', "%{$skill}%")
                        ->orWhere('description', 'like', "%{$skill}%");
                });
            });
        }

        if ($request->filled('min_rating')) {
            $minRating = (float) $request->min_rating;

            $query->having('reviews_received_avg_rating', '>=', $minRating);
        }

        match ($request->get('sort')) {
            'rating' => $query->orderByDesc('reviews_received_avg_rating'),
            'popular' => $query->orderByDesc('tailor_orders_count'),
            'portfolio' => $query->orderByDesc('portfolios_count'),
            default => $query->latest(),
        };

        $tailors = $query->paginate(12)->withQueryString();

        return view('public.tailors.index', compact('tailors', 'skillOptions'));
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
        $activeOrdersCount = $tailor->activeTailorOrdersCount();
        $weeklyOrdersCount = $tailor->weeklyTailorOrdersCount();
        $isAtCapacity = $tailor->isAtOrderCapacity();
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $tailor->reviewsReceived()->where('rating', $i)->count();
            $ratingBreakdown[$i] = [
                'count'   => $count,
                'percent' => $reviewCount > 0 ? round($count / $reviewCount * 100) : 0,
            ];
        }

        return view('public.tailors.show', compact('tailor', 'reviews', 'avgRating', 'reviewCount', 'ratingBreakdown', 'activeOrdersCount', 'weeklyOrdersCount', 'isAtCapacity'));
    }
}
