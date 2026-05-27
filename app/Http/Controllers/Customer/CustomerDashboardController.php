<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    /**
     * Tampilkan dashboard customer dengan statistik order.
     */
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total'               => $user->customerOrders()->count(),
            'menunggu_pembayaran' => $user->customerOrders()->where('status', OrderStatus::MenungguPembayaran->value)->count(),
            'diproses'            => $user->customerOrders()->where('status', OrderStatus::Diproses->value)->count(),
            'finishing'           => $user->customerOrders()->where('status', OrderStatus::Finishing->value)->count(),
            'siap_diambil'        => $user->customerOrders()->where('status', OrderStatus::SiapDiambil->value)->count(),
            'selesai'             => $user->customerOrders()->where('status', OrderStatus::Selesai->value)->count(),
        ];

        $recentOrders = $user->customerOrders()
            ->with(['tailor.tailorProfile', 'priceList'])
            ->latest()
            ->limit(5)
            ->get();

        // Ambil 4 penjahit unggulan yang terverifikasi dan tersedia
        $featuredTailors = User::whereHas('tailorProfile', function ($q) {
                $q->where('is_verified', true)->where('is_available', true);
            })
            ->with(['tailorProfile', 'portfolios'])
            ->withCount('portfolios')
            ->limit(4)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentOrders', 'featuredTailors'));
    }
}
