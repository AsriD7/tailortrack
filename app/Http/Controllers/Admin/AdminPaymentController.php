<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminPaymentController extends Controller
{
    /**
     * Tampilkan semua data pembayaran.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['order.customer', 'order.tailor.tailorProfile']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(15);
        $statuses = PaymentStatus::cases();

        return view('admin.payments.index', compact('payments', 'statuses'));
    }

    /**
     * Tampilkan detail satu pembayaran.
     */
    public function show(Payment $payment)
    {
        $payment->load(['order.customer', 'order.tailor.tailorProfile', 'order.trackingHistories.updatedByUser']);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Admin memverifikasi pembayaran.
     * - Payment status → verified
     * - Order status   → diproses
     */
    public function verify(Payment $payment)
    {
        if ($payment->status !== PaymentStatus::Pending) {
            return back()->with('error', 'Pembayaran ini sudah diproses sebelumnya.');
        }

        $payment->update(['status' => PaymentStatus::Verified]);

        $order = $payment->order;
        $order->update(['status' => OrderStatus::Diproses]);

        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => OrderStatus::Diproses->value,
            'description' => 'Pembayaran telah diverifikasi oleh admin. Pesanan mulai diproses oleh penjahit.',
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Pembayaran berhasil diverifikasi. Pesanan sekarang sedang diproses.');
    }

    /**
     * Admin menolak pembayaran.
     * - Payment status → rejected
     * - Order status   → menunggu_pembayaran
     */
    public function reject(Request $request, Payment $payment)
    {
        if ($payment->status !== PaymentStatus::Pending) {
            return back()->with('error', 'Pembayaran ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'reject_reason' => 'nullable|string|max:500',
        ]);

        $payment->update(['status' => PaymentStatus::Rejected]);

        $order = $payment->order;
        $order->update(['status' => OrderStatus::MenungguPembayaran]);

        $reason = $request->reject_reason ?? 'Bukti pembayaran tidak valid atau tidak sesuai.';

        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => OrderStatus::MenungguPembayaran->value,
            'description' => "Pembayaran ditolak oleh admin. Alasan: {$reason} Customer diminta upload ulang bukti pembayaran.",
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Pembayaran ditolak. Customer akan diminta upload ulang bukti pembayaran.');
    }
}
