<?php

namespace App\Http\Controllers\Tailor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TailorReviewController extends Controller
{
    /**
     * Tampilkan semua ulasan yang diterima penjahit ini.
     */
    public function index()
    {
        $user = Auth::user();

        $reviews = $user->reviewsReceived()
            ->with(['customer:id,name', 'order:id,order_code,item_name'])
            ->latest()
            ->paginate(10);

        $avgRating   = $user->reviewsReceived()->avg('rating');
        $totalReviews = $user->reviewsReceived()->count();

        // Breakdown per bintang
        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $user->reviewsReceived()->where('rating', $i)->count();
            $breakdown[$i] = [
                'count'   => $count,
                'percent' => $totalReviews > 0 ? round($count / $totalReviews * 100) : 0,
            ];
        }

        return view('tailor.reviews.index', compact(
            'reviews', 'avgRating', 'totalReviews', 'breakdown'
        ));
    }
}
