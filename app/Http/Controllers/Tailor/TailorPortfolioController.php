<?php

namespace App\Http\Controllers\Tailor;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TailorPortfolioController extends Controller
{
    /**
     * Tampilkan semua portfolio milik penjahit yang login.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->portfolios();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('client_type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $portfolios = $query
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $baseQuery = Auth::user()->portfolios();
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'featured' => (clone $baseQuery)->where('is_featured', true)->count(),
            'categories' => (clone $baseQuery)->whereNotNull('category')->distinct()->count('category'),
        ];
        $categoryOptions = $this->categoryOptions();

        return view('tailor.portfolios.index', compact('portfolios', 'stats', 'categoryOptions'));
    }

    /**
     * Tampilkan form tambah portfolio baru.
     */
    public function create()
    {
        $categoryOptions = $this->categoryOptions();
        $clientTypeOptions = Portfolio::CLIENT_TYPE_OPTIONS;

        return view('tailor.portfolios.create', compact('categoryOptions', 'clientTypeOptions'));
    }

    /**
     * Simpan portfolio baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'client_type' => 'nullable|string|max:100',
            'price_range' => 'nullable|string|max:100',
            'completed_at' => 'nullable|date|before_or_equal:today',
            'is_featured' => 'nullable|boolean',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'nullable|string|max:1000',
        ], [
            'title.required'  => 'Judul portfolio wajib diisi.',
            'image.required'  => 'Gambar portfolio wajib diunggah.',
            'image.image'     => 'File harus berupa gambar.',
            'image.max'       => 'Ukuran gambar maksimal 5MB.',
            'completed_at.before_or_equal' => 'Tanggal selesai tidak boleh melebihi hari ini.',
        ]);

        $path = $request->file('image')->store('portfolios', 'public');

        Portfolio::create([
            'tailor_id'   => Auth::id(),
            'title'       => $request->title,
            'category'    => $request->category,
            'client_type' => $request->client_type,
            'price_range' => $request->price_range,
            'completed_at' => $request->completed_at,
            'is_featured' => $request->boolean('is_featured'),
            'image'       => $path,
            'description' => $request->description,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ]);

        return redirect()->route('tailor.portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan.');
    }

    /**
     * Arahkan detail portfolio internal ke halaman edit.
     */
    public function show(Portfolio $portfolio)
    {
        abort_if($portfolio->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        return redirect()->route('tailor.portfolios.edit', $portfolio);
    }

    /**
     * Tampilkan form edit portfolio.
     */
    public function edit(Portfolio $portfolio)
    {
        abort_if($portfolio->tailor_id !== Auth::id(), 403, 'Akses ditolak.');

        $categoryOptions = $this->categoryOptions();
        $clientTypeOptions = Portfolio::CLIENT_TYPE_OPTIONS;

        return view('tailor.portfolios.edit', compact('portfolio', 'categoryOptions', 'clientTypeOptions'));
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
            'client_type' => 'nullable|string|max:100',
            'price_range' => 'nullable|string|max:100',
            'completed_at' => 'nullable|date|before_or_equal:today',
            'is_featured' => 'nullable|boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'Judul portfolio wajib diisi.',
            'image.image'    => 'File harus berupa gambar.',
            'image.max'      => 'Ukuran gambar maksimal 5MB.',
            'completed_at.before_or_equal' => 'Tanggal selesai tidak boleh melebihi hari ini.',
        ]);

        $data = [
            'title'       => $request->title,
            'category'    => $request->category,
            'client_type' => $request->client_type,
            'price_range' => $request->price_range,
            'completed_at' => $request->completed_at,
            'is_featured' => $request->boolean('is_featured'),
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }

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

        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()->route('tailor.portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus.');
    }

    /**
     * Opsi kategori dari data layanan dan kategori default.
     */
    private function categoryOptions(): array
    {
        return collect(Portfolio::CATEGORY_OPTIONS)
            ->merge(Auth::user()->priceLists()->pluck('category'))
            ->merge(Auth::user()->priceLists()->pluck('name'))
            ->filter()
            ->unique(fn($value) => mb_strtolower($value))
            ->sort()
            ->values()
            ->all();
    }
}
