<?php

namespace App\Http\Controllers\Tailor;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TailorDashboardController extends Controller
{
    /**
     * Tampilkan dashboard penjahit dengan statistik order dan pendapatan.
     */
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total'                => $user->tailorOrders()->count(),
            'menunggu_konfirmasi'  => $user->tailorOrders()->where('status', OrderStatus::MenungguKonfirmasi->value)->count(),
            'diproses'             => $user->tailorOrders()->where('status', OrderStatus::Diproses->value)->count(),
            'selesai'              => $user->tailorOrders()->where('status', OrderStatus::Selesai->value)->count(),
            'active_orders'         => $user->activeTailorOrdersCount(),
            'weekly_orders'         => $user->weeklyTailorOrdersCount(),
            'is_at_capacity'        => $user->isAtOrderCapacity(),
            'total_revenue'        => $user->tailorOrders()
                ->where('status', OrderStatus::Selesai->value)
                ->sum('total_price'),
        ];

        $recentOrders = $user->tailorOrders()
            ->with(['customer', 'priceList'])
            ->latest()
            ->limit(5)
            ->get();

        $tailorProfile = $user->tailorProfile;

        return view('tailor.dashboard', compact('stats', 'recentOrders', 'tailorProfile'));

    }
}
