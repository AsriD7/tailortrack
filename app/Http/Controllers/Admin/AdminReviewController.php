<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    /**
     * Tampilkan daftar review untuk kebutuhan moderasi admin.
     */
    public function index(Request $request)
    {
        $query = Review::with([
            'customer',
            'tailor.tailorProfile',
            'order',
        ])->latest();

        if ($request->filled('rating')) {
            $query->where('rating', $request->integer('rating'));
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tailor', function ($tailor) use ($search) {
                        $tailor->where('name', 'like', "%{$search}%")
                            ->orWhereHas('tailorProfile', function ($profile) use ($search) {
                                $profile->where('shop_name', 'like', "%{$search}%");
                            });
                    })
                    ->orWhereHas('order', function ($order) use ($search) {
                        $order->where('order_code', 'like', "%{$search}%");
                    });
            });
        }

        $reviews = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Review::count(),
            'average' => round((float) Review::avg('rating'), 1),
            'low_rating' => Review::where('rating', '<=', 2)->count(),
            'with_comment' => Review::whereNotNull('comment')->where('comment', '!=', '')->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Hapus review yang tidak layak tampil.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review berhasil dihapus dari platform.');
    }
}
