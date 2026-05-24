<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    /**
     * Tampilkan semua order di sistem dengan filter.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'tailor.tailorProfile', 'priceList']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tailor_id')) {
            $query->where('tailor_id', $request->tailor_id);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('search')) {
            $query->where('order_code', 'like', "%{$request->search}%");
        }

        $orders   = $query->latest()->paginate(15);
        $statuses = OrderStatus::cases();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Tampilkan detail satu order.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'tailor.tailorProfile', 'priceList', 'orderImages', 'payment', 'trackingHistories.updatedByUser', 'cancelledBy']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Admin membatalkan order.
     */
    public function cancel(Request $request, Order $order)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ], [
            'cancel_reason.required' => 'Alasan pembatalan wajib diisi.',
        ]);

        if (!$order->canBeCancelledBy(Auth::user())) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan pada status saat ini.');
        }

        $order->update([
            'status'        => OrderStatus::Dibatalkan,
            'cancelled_by'  => Auth::id(),
            'cancel_reason' => $request->cancel_reason,
            'cancelled_at'  => Carbon::now(),
        ]);

        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => OrderStatus::Dibatalkan->value,
            'description' => "Pesanan dibatalkan oleh admin. Alasan: {$request->cancel_reason}",
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
