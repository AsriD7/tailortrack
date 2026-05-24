<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
use App\Models\Portfolio;
use App\Models\TailorProfile;
use App\Models\User;
use App\Enums\UserRole;

class LandingController extends Controller
{
    /**
     * Tampilkan landing page dengan data penjahit dan portfolio terbaru.
     */
    public function index()
    {
        // Ambil beberapa penjahit yang sudah terverifikasi
        $tailors = User::where('role', UserRole::Tailor->value)
            ->whereHas('tailorProfile', fn($q) => $q->where('is_verified', true)->where('is_available', true))
            ->with('tailorProfile')
            ->limit(6)
            ->get();

        // Ambil portfolio terbaru
        $portfolios = Portfolio::with('tailor.tailorProfile')
            ->latest()
            ->limit(6)
            ->get();

        // Ambil beberapa daftar harga
        $priceLists = PriceList::limit(6)->get();

        return view('public.landing', compact('tailors', 'portfolios', 'priceLists'));
    }
}
