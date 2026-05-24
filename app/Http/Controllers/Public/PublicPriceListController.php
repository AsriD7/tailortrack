<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PriceList;

class PublicPriceListController extends Controller
{
    /**
     * Tampilkan semua daftar harga layanan jahit.
     */
    public function index()
    {
        $priceLists = PriceList::orderBy('category')->orderBy('name')->get();

        // Kelompokkan berdasarkan kategori
        $grouped = $priceLists->groupBy('category');

        return view('public.price-lists.index', compact('priceLists', 'grouped'));
    }
}
