<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerPaymentController extends Controller
{
    /**
     * Customer upload bukti pembayaran untuk order tertentu.
     */
    public function store(Request $request, Order $order)
    {
        // Pastikan order milik customer yang login
        abort_if($order->customer_id !== Auth::id(), 403, 'Akses ditolak.');

        // Hanya boleh upload jika status menunggu pembayaran
        if ($order->status !== OrderStatus::MenungguPembayaran) {
            return back()->with('error', 'Pembayaran hanya dapat diupload saat pesanan menunggu pembayaran.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'payment_date'  => 'nullable|date',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Upload bukti bayar ke storage
        $path = $request->file('payment_proof')->store('payments', 'public');

        // Hapus payment lama jika ada (kasus upload ulang setelah ditolak)
        $order->payment()->delete();

        // Buat record payment baru
        Payment::create([
            'order_id'      => $order->id,
            'payment_proof' => $path,
            'payment_date'  => $request->payment_date ?? Carbon::today(),
            'status'        => PaymentStatus::Pending,
        ]);

        // Update status order menjadi dibayar
        $order->update(['status' => OrderStatus::Dibayar]);

        // Tambah tracking history
        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => OrderStatus::Dibayar->value,
            'description' => 'Bukti pembayaran telah diupload oleh customer. Menunggu verifikasi admin.',
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
