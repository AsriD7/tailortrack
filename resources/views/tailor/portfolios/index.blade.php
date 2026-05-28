@extends('layouts.app')

@section('title', 'Portfolio Saya')
@section('page-title', 'Portfolio')
@section('page-subtitle', 'Tampilkan karya terbaik Anda kepada calon pelanggan')

@section('page-actions')
    <a href="{{ route('tailor.portfolios.create') }}"
       class="brand-gradient text-white px-4 py-2 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity flex items-center gap-2 shadow-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Portfolio
    </a>
@endsection

@section('sidebar-nav')
    <a href="{{ route('tailor.dashboard') }}"
       class="nav-link {{ request()->routeIs('tailor.dashboard*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('tailor.profile.edit') }}"
       class="nav-link {{ request()->routeIs('tailor.profile*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        Profil Toko
    </a>
    <a href="{{ route('tailor.portfolios.index') }}"
       class="nav-link {{ request()->routeIs('tailor.portfolios*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Portfolio
    </a>
    <a href="{{ route('tailor.orders.index') }}"
       class="nav-link {{ request()->routeIs('tailor.orders*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
        </svg>
        Pesanan Masuk
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <section class="overflow-hidden rounded-[2rem] border border-tailor-purple/10 bg-white shadow-soft">
        <div class="relative brand-gradient p-5 text-white sm:p-7">
            <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-[radial-gradient(circle_at_top_right,rgba(240,179,79,0.35),transparent_55%)] sm:block"></div>
            <div class="relative flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-tailor-gold">Portfolio Toko</p>
                    <h1 class="mt-2 text-2xl font-black tracking-tight sm:text-3xl">Karya jahitan terbaik</h1>
                    <p class="mt-2 max-w-2xl text-sm font-medium leading-6 text-white/75">
                        Kelola foto karya, kategori, harga, dan karya unggulan yang tampil di profil publik.
                    </p>
                </div>
                <a href="{{ route('tailor.portfolios.create') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-extrabold text-tailor-purple shadow-sm transition hover:bg-tailor-cream">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Portfolio
                </a>
            </div>
        </div>
    </section>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-4">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Karya</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-4">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Karya Unggulan</p>
            <p class="text-2xl font-extrabold text-tailor-purple mt-1">{{ $stats['featured'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-4">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kategori</p>
            <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['categories'] ?? 0 }}</p>
        </div>
    </div>

    <form method="GET" action="{{ route('tailor.portfolios.index') }}" class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-4">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-5">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul, kategori, atau deskripsi..."
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent">
            </div>
            <div class="md:col-span-4">
                <select name="category"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent">
                    <option value="">Semua kategori</option>
                    @foreach($categoryOptions as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <label class="md:col-span-2 inline-flex items-center gap-2 px-3 py-2.5 rounded-lg border border-slate-200 text-sm font-semibold text-slate-600">
                <input type="checkbox" name="featured" value="1" class="rounded border-slate-300 text-tailor-purple focus:ring-tailor-gold" {{ request()->boolean('featured') ? 'checked' : '' }}>
                Unggulan
            </label>
            <button type="submit"
                    class="md:col-span-1 inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-tailor-deep text-white text-sm font-semibold hover:bg-tailor-purple transition-colors">
                Cari
            </button>
        </div>
    </form>

    @if($portfolios->count() > 0)
        {{-- Portfolio Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($portfolios as $portfolio)
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden group hover:shadow-md transition-shadow">
                    {{-- Portfolio Image --}}
                    <div class="relative aspect-video overflow-hidden bg-slate-100">
                        @if($portfolio->image)
                            <img src="{{ asset('storage/' . $portfolio->image) }}"
                                 alt="{{ $portfolio->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs text-slate-400 mt-2">Belum ada gambar</p>
                            </div>
                        @endif

                        {{-- Category Badge overlay --}}
                        @if($portfolio->category)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-tailor-purple shadow-sm">
                                    {{ $portfolio->category }}
                                </span>
                            </div>
                        @endif
                        @if($portfolio->is_featured)
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-400 text-amber-950 shadow-sm">
                                    Unggulan
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Portfolio Info --}}
                    <div class="p-4">
                        <h3 class="font-semibold text-slate-800 text-sm leading-snug mb-1.5">{{ $portfolio->title }}</h3>

                        @if($portfolio->description)
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $portfolio->description }}</p>
                        @endif

                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @if($portfolio->client_type)
                                <span class="inline-flex px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">{{ $portfolio->client_type }}</span>
                            @endif
                            @if($portfolio->price_range)
                                <span class="inline-flex px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold">{{ $portfolio->price_range }}</span>
                            @endif
                            @if($portfolio->completed_at)
                                <span class="inline-flex px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[11px] font-semibold">{{ $portfolio->completed_at->format('M Y') }}</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 mt-4 pt-3 border-t border-slate-100">
                            <a href="{{ route('tailor.portfolios.edit', $portfolio) }}"
                               class="flex-1 flex items-center justify-center gap-1.5 bg-slate-100 text-slate-700 px-3 py-2 rounded-lg font-semibold text-xs hover:bg-tailor-soft hover:text-tailor-purple transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('tailor.portfolios.destroy', $portfolio) }}" method="POST"
                                  onsubmit="return confirmDelete(event, '{{ $portfolio->title }}')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-1.5 bg-red-50 text-red-600 px-3 py-2 rounded-lg font-semibold text-xs hover:bg-red-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($portfolios->hasPages())
            <div class="flex justify-center">
                {{ $portfolios->links() }}
            </div>
        @endif

    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-12 text-center">
            <div class="w-20 h-20 bg-tailor-soft rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-tailor-purple/35" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-700 mb-1">Belum Ada Portfolio</h3>
            <p class="text-sm text-slate-400 max-w-sm mx-auto mb-6">
                Tambahkan karya terbaik Anda untuk menarik lebih banyak pelanggan dan meningkatkan kepercayaan.
            </p>
            <a href="{{ route('tailor.portfolios.create') }}"
               class="inline-flex items-center gap-2 brand-gradient text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Portfolio Pertama
            </a>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(event, title) {
        if (!confirm(`Hapus portfolio "${title}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
@endpush
