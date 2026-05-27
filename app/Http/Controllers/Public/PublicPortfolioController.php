<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PublicPortfolioController extends Controller
{
    /**
     * Tampilkan semua portfolio publik dengan filter.
     */
    public function index(Request $request)
    {
        $query = Portfolio::with('tailor.tailorProfile')
            ->whereHas('tailor.tailorProfile', fn($q) => $q->where('is_verified', true));

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('tailor', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('tailor.tailorProfile', function ($q2) use ($search) {
                      $q2->where('shop_name', 'like', "%{$search}%");
                  });
            });
        }

        $portfolios = $query->latest()->paginate(12)->withQueryString();
        $categories = Portfolio::CATEGORY_OPTIONS;

        return view('public.portfolios.index', compact('portfolios', 'categories'));
    }

    /**
     * Tampilkan detail portfolio.
     */
    public function show(Portfolio $portfolio)
    {
        $portfolio->load('tailor.tailorProfile');

        // Portfolio terkait dari penjahit yang sama
        $relatedPortfolios = Portfolio::where('tailor_id', $portfolio->tailor_id)
            ->where('id', '!=', $portfolio->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('public.portfolios.show', compact('portfolio', 'relatedPortfolios'));
    }
}
