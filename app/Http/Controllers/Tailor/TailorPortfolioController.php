<?php

namespace App\Http\Controllers\Tailor;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TailorPortfolioController extends Controller
{
    /**
     * Tampilkan semua portfolio milik penjahit yang login.
     */
    public function index()
    {
        $portfolios = Auth::user()->portfolios()->latest()->paginate(12);

        return view('tailor.portfolios.index', compact('portfolios'));
    }

    /**
     * Tampilkan form tambah portfolio baru.
     */
    public function create()
    {
        return view('tailor.portfolios.create');
    }

    /**
     * Simpan portfolio baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string|max:1000',
        ], [
            'title.required'  => 'Judul portfolio wajib diisi.',
            'image.required'  => 'Gambar portfolio wajib diunggah.',
            'image.image'     => 'File harus berupa gambar.',
            'image.max'       => 'Ukuran gambar maksimal 2MB.',
        ]);

        $path = $request->file('image')->store('portfolios', 'public');

        Portfolio::create([
            'tailor_id'   => Auth::id(),
            'title'       => $request->title,
            'category'    => $request->category,
            'image'       => $path,
            'description' => $request->description,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ]);

        return redirect()->route('tailor.portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit portfolio.
     */
    public function edit(Portfolio $portfolio)
    {
        abort_if($portfolio->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        return view('tailor.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update data portfolio.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        abort_if($portfolio->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'Judul portfolio wajib diisi.',
            'image.image'    => 'File harus berupa gambar.',
            'image.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio->update($data);

        return redirect()->route('tailor.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui.');
    }

    /**
     * Hapus portfolio.
     */
    public function destroy(Portfolio $portfolio)
    {
        abort_if($portfolio->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        $portfolio->delete();

        return redirect()->route('tailor.portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus.');
    }
}
