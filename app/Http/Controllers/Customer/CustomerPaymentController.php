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

        $order->loadMissing('payments');

        $bankKeys = array_keys(config('payments.banks', []));

        $request->validate([
            'payment_type'  => 'required|in:full,dp,pelunasan',
            'bank_key'      => 'required|in:' . implode(',', $bankKeys),
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'payment_date'  => 'nullable|date',
        ], [
            'payment_type.required'  => 'Pilih jenis pembayaran terlebih dahulu.',
            'payment_type.in'        => 'Jenis pembayaran tidak valid.',
            'bank_key.required'      => 'Pilih rekening tujuan terlebih dahulu.',
            'bank_key.in'            => 'Rekening tujuan tidak valid.',
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        $paymentType = $request->payment_type;
        $totalPrice = (float) $order->total_price;
        $dpPercentage = max(1, min(100, (int) config('payments.dp_percentage', 50)));

        if ($paymentType === Payment::TYPE_FINAL) {
            if ($order->status !== OrderStatus::SiapDiambil || !$order->hasVerifiedDpPayment()) {
                return back()->with('error', 'Pelunasan hanya dapat diupload setelah pesanan siap diambil dan DP sudah diverifikasi.');
            }

            if ($order->hasPendingFinalPayment()) {
                return back()->with('error', 'Bukti pelunasan sebelumnya masih menunggu verifikasi admin.');
            }

            $paymentAmount = $order->paymentRemainingAmount();

            if ($paymentAmount <= 0) {
                return back()->with('error', 'Pesanan ini sudah lunas.');
            }
        } else {
            if ($order->status !== OrderStatus::MenungguPembayaran) {
                return back()->with('error', 'Pembayaran awal hanya dapat diupload saat pesanan menunggu pembayaran.');
            }

            $hasPendingInitialPayment = $order->payments
                ->contains(fn(Payment $payment) =>
                    in_array($payment->payment_type, [Payment::TYPE_FULL, Payment::TYPE_DP], true)
                    && $payment->status === PaymentStatus::Pending
                );

            if ($hasPendingInitialPayment) {
                return back()->with('error', 'Bukti pembayaran sebelumnya masih menunggu verifikasi admin.');
            }

            $paymentAmount = $paymentType === Payment::TYPE_DP
                ? round($totalPrice * ($dpPercentage / 100), 2)
                : $totalPrice;
        }

        // Upload bukti bayar ke storage
        $path = $request->file('payment_proof')->store('payments', 'public');
        $bank = config("payments.banks.{$request->bank_key}");

        // Buat record payment baru
        Payment::create([
            'order_id'      => $order->id,
            'payment_type'  => $paymentType,
            'amount'        => $paymentAmount,
            'bank_name'     => $bank['name'] ?? null,
            'bank_account_number' => $bank['account_number'] ?? null,
            'bank_account_name' => $bank['account_name'] ?? null,
            'payment_proof' => $path,
            'payment_date'  => $request->payment_date ?? Carbon::today(),
            'status'        => PaymentStatus::Pending,
        ]);

        if ($paymentType !== Payment::TYPE_FINAL) {
            $order->update(['status' => OrderStatus::Dibayar]);
        }

        // Tambah tracking history
        $trackingStatus = $paymentType === Payment::TYPE_FINAL
            ? OrderStatus::SiapDiambil
            : OrderStatus::Dibayar;
        $description = match ($paymentType) {
            Payment::TYPE_DP => 'Bukti pembayaran DP telah diupload oleh customer. Menunggu verifikasi admin.',
            Payment::TYPE_FINAL => 'Bukti pelunasan sisa pembayaran telah diupload oleh customer. Menunggu verifikasi admin.',
            default => 'Bukti pembayaran full telah diupload oleh customer. Menunggu verifikasi admin.',
        };

        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => $trackingStatus->value,
            'description' => $description,
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
