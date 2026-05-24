<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan statistik sistem.
     */
    public function index()
    {
        $stats = [
            'total_customer'       => User::where('role', UserRole::Customer->value)->count(),
            'total_tailor'         => User::where('role', UserRole::Tailor->value)->count(),
            'total_order'          => Order::count(),
            'pending_payment'      => Payment::where('status', 'pending')->count(),
            'total_revenue'        => Order::where('status', OrderStatus::Selesai->value)->sum('total_price'),
        ];

        $recentOrders = Order::with(['customer', 'tailor.tailorProfile', 'priceList'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
