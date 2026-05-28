<?php

namespace App\Http\Controllers\Tailor;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TailorOrderController extends Controller
{
    /**
     * Tampilkan semua order yang masuk ke penjahit ini.
     */
    public function index()
    {
        $orders = Auth::user()->tailorOrders()
            ->with(['customer', 'priceList'])
            ->latest()
            ->paginate(10);

        return view('tailor.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail satu order penjahit.
     */
    public function show(Order $order)
    {
        abort_if($order->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        $order->load(['customer', 'priceList', 'orderImages', 'payment', 'payments', 'trackingHistories.updatedByUser']);

        return view('tailor.orders.show', compact('order'));
    }

    /**
     * Penjahit konfirmasi atau ubah harga total order.
     */
    public function confirmPrice(Request $request, Order $order)
    {
        abort_if($order->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        if ($order->status !== OrderStatus::MenungguKonfirmasi) {
            return back()->with('error', 'Konfirmasi harga hanya dapat dilakukan saat pesanan menunggu konfirmasi.');
        }

        $validated = $request->validate([
            'total_price' => 'required|numeric|min:0',
            'confirm_note' => 'nullable|string|max:500',
        ], [
            'total_price.required' => 'Harga total wajib diisi.',
            'total_price.numeric'  => 'Harga total harus berupa angka.',
            'total_price.min'      => 'Harga total tidak boleh negatif.',
        ]);

        $order->update([
            'total_price' => $validated['total_price'],
            'status'      => OrderStatus::MenungguPembayaran,
        ]);

        $defaultDescription = "Harga pesanan dikonfirmasi oleh penjahit sebesar Rp " . number_format($validated['total_price'], 0, ',', '.') . ". Customer diminta melakukan pembayaran.";

        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => OrderStatus::MenungguPembayaran->value,
            'description' => $validated['confirm_note'] ?: $defaultDescription,
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('tailor.orders.show', $order)
            ->with('success', 'Harga berhasil dikonfirmasi. Customer akan segera melakukan pembayaran.');
    }

    /**
     * Penjahit update status order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        abort_if($order->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        $allowedStatuses = collect($order->status->availableTailorProgressTargets())
            ->map->value
            ->all();

        if (empty($allowedStatuses)) {
            return back()->with('error', 'Status pesanan saat ini belum dapat diubah oleh penjahit.');
        }

        $request->validate([
            'status'      => ['required', 'in:' . implode(',', $allowedStatuses)],
            'description' => 'nullable|string|max:500',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
        ]);

        $newStatus = OrderStatus::from($request->status);

        if (!in_array($newStatus->value, $allowedStatuses, true)) {
            return back()->with('error', 'Transisi status tidak diizinkan.');
        }

        if ($newStatus === OrderStatus::Selesai && !$order->isFullyPaid()) {
            return back()->with('error', 'Pesanan belum bisa diselesaikan karena sisa pembayaran belum diverifikasi admin.');
        }

        $order->update(['status' => $newStatus]);

        $description = $request->description ?: $newStatus->defaultTrackingDescription();

        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => $newStatus->value,
            'description' => $description,
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('tailor.orders.show', $order)
            ->with('success', "Status pesanan berhasil diperbarui menjadi '{$newStatus->label()}'.");
    }

    /**
     * Penjahit menolak / membatalkan order (hanya saat menunggu konfirmasi).
     */
    public function cancel(Request $request, Order $order)
    {
        abort_if($order->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ], [
            'cancel_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if ($order->status !== OrderStatus::MenungguKonfirmasi) {
            return back()->with('error', 'Penolakan hanya dapat dilakukan saat pesanan menunggu konfirmasi.');
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
            'description' => "Pesanan ditolak oleh penjahit. Alasan: {$request->cancel_reason}",
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('tailor.orders.index')
            ->with('success', 'Pesanan berhasil ditolak.');
    }
}
