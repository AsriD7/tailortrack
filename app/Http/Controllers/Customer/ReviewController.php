<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Simpan ulasan baru untuk pesanan yang sudah selesai.
     */
    public function store(Request $request, Order $order)
    {
        $user = Auth::user();

        // Pastikan order milik customer ini
        if ($order->customer_id !== $user->id) {
            abort(403, 'Anda tidak berhak memberikan ulasan untuk pesanan ini.');
        }

        // Pastikan pesanan sudah selesai
        if ($order->status !== OrderStatus::Selesai) {
            return back()->with('error', 'Ulasan hanya dapat diberikan untuk pesanan yang sudah selesai.');
        }

        // Cek apakah sudah pernah memberikan ulasan
        if ($order->review()->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Pilih rating bintang terlebih dahulu.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
            'comment.max'     => 'Komentar maksimal 1000 karakter.',
        ]);

        Review::create([
            'order_id'    => $order->id,
            'customer_id' => $user->id,
            'tailor_id'   => $order->tailor_id,
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim. ⭐');
    }

    /**
     * Hapus ulasan (hanya boleh oleh customer yg bersangkutan).
     */
    public function destroy(Review $review)
    {
        $user = Auth::user();

        if ($review->customer_id !== $user->id) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
