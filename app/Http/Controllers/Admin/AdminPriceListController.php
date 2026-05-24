<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
use Illuminate\Http\Request;

class AdminPriceListController extends Controller
{
    /**
     * Tampilkan semua daftar harga.
     */
    public function index()
    {
        $priceLists = PriceList::orderBy('category')->orderBy('name')->paginate(15);

        return view('admin.price-lists.index', compact('priceLists'));
    }

    /**
     * Tampilkan form tambah daftar harga.
     */
    public function create()
    {
        return view('admin.price-lists.create');
    }

    /**
     * Simpan daftar harga baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'base_price'  => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required'       => 'Nama layanan wajib diisi.',
            'category.required'   => 'Kategori wajib diisi.',
            'base_price.required' => 'Harga dasar wajib diisi.',
            'base_price.numeric'  => 'Harga dasar harus berupa angka.',
            'base_price.min'      => 'Harga dasar tidak boleh negatif.',
        ]);

        PriceList::create($request->only('name', 'category', 'base_price', 'description'));

        return redirect()->route('admin.price-lists.index')
            ->with('success', 'Daftar harga berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit daftar harga.
     */
    public function edit(PriceList $priceList)
    {
        return view('admin.price-lists.edit', compact('priceList'));
    }

    /**
     * Update daftar harga.
     */
    public function update(Request $request, PriceList $priceList)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'base_price'  => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required'       => 'Nama layanan wajib diisi.',
            'category.required'   => 'Kategori wajib diisi.',
            'base_price.required' => 'Harga dasar wajib diisi.',
            'base_price.numeric'  => 'Harga dasar harus berupa angka.',
        ]);

        $priceList->update($request->only('name', 'category', 'base_price', 'description'));

        return redirect()->route('admin.price-lists.index')
            ->with('success', 'Daftar harga berhasil diperbarui.');
    }

    /**
     * Hapus daftar harga.
     */
    public function destroy(PriceList $priceList)
    {
        $priceList->delete();

        return redirect()->route('admin.price-lists.index')
            ->with('success', 'Daftar harga berhasil dihapus.');
    }
}
