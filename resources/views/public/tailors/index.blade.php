@extends('layouts.customer')

@section('title', 'Daftar Penjahit - TailorTrack')
@section('fullwidth', true)

@section('content')
<section class="bg-tailor-cream">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <nav class="mb-8 flex items-center gap-2 text-sm font-semibold text-slate-500">
            <a href="{{ route('landing') }}" class="hover:text-tailor-purple">Beranda</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-tailor-purple">Penjahit</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-[1fr_0.78fr] lg:items-end">
            <div>
                <span class="inline-flex rounded-full bg-white px-4 py-2 text-sm font-extrabold text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                    {{ $tailors->total() }} penjahit tersedia
                </span>
                <h1 class="mt-5 max-w-3xl text-4xl font-black leading-tight text-tailor-deep sm:text-5xl">
                    Pilih penjahit yang cocok untuk pesanan custom kamu.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600">
                    Cari berdasarkan nama toko, keahlian, rating, atau jumlah portfolio. Setiap kartu dibuat ringkas agar mudah dipindai dari mobile.
                </p>
            </div>

            <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-tailor-purple/10">
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="rounded-2xl bg-tailor-cream p-4">
                        <p class="text-2xl font-black text-tailor-purple">{{ $tailors->total() }}</p>
                        <p class="mt-1 text-xs font-bold text-slate-500">Penjahit</p>
                    </div>
                    <div class="rounded-2xl bg-tailor-cream p-4">
                        <p class="text-2xl font-black text-tailor-purple">{{ $skillOptions->count() }}</p>
                        <p class="mt-1 text-xs font-bold text-slate-500">Keahlian</p>
                    </div>
                    <div class="rounded-2xl bg-tailor-cream p-4">
                        <p class="text-2xl font-black text-tailor-purple">4+</p>
                        <p class="mt-1 text-xs font-bold text-slate-500">Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('tailors.index') }}" class="rounded-3xl border border-tailor-purple/10 bg-white p-4 shadow-soft sm:p-5">
            <div class="grid gap-3 lg:grid-cols-12">
                <label class="relative lg:col-span-5">
                    <span class="sr-only">Cari penjahit</span>
                    <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-tailor-purple/45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko, penjahit, atau keahlian..." class="h-12 w-full rounded-2xl border border-tailor-purple/10 bg-tailor-cream pl-12 pr-4 text-sm font-semibold text-tailor-ink outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20">
                </label>

                <select name="skill" class="h-12 rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-4 text-sm font-semibold text-tailor-ink outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20 lg:col-span-3">
                    <option value="">Semua Keahlian</option>
                    @foreach($skillOptions as $skill)
                        <option value="{{ $skill }}" {{ request('skill') === $skill ? 'selected' : '' }}>{{ $skill }}</option>
                    @endforeach
                </select>

                <select name="min_rating" class="h-12 rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-4 text-sm font-semibold text-tailor-ink outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20 lg:col-span-2">
                    <option value="">Semua Rating</option>
                    <option value="4" {{ request('min_rating') === '4' ? 'selected' : '' }}>Rating 4+</option>
                    <option value="3" {{ request('min_rating') === '3' ? 'selected' : '' }}>Rating 3+</option>
                </select>

                <select name="sort" class="h-12 rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-4 text-sm font-semibold text-tailor-ink outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20 lg:col-span-2">
                    <option value="">Terbaru</option>
                    <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Paling Banyak Order</option>
                    <option value="portfolio" {{ request('sort') === 'portfolio' ? 'selected' : '' }}>Portfolio Terbanyak</option>
                </select>
            </div>

            <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex gap-2 overflow-x-auto pb-1">
                    @foreach($skillOptions->take(7) as $skill)
                        <a href="{{ route('tailors.index', array_filter(array_merge(request()->except('page'), ['skill' => $skill]))) }}" class="shrink-0 rounded-full px-3 py-2 text-xs font-black transition {{ request('skill') === $skill ? 'bg-tailor-purple text-white' : 'bg-tailor-soft text-tailor-purple hover:bg-tailor-purple hover:text-white' }}">
                            {{ $skill }}
                        </a>
                    @endforeach
                </div>

                <div class="grid grid-cols-2 gap-2 sm:flex sm:shrink-0">
                    @if(request()->hasAny(['search', 'skill', 'min_rating', 'sort']))
                        <a href="{{ route('tailors.index') }}" class="rounded-2xl bg-slate-100 px-5 py-3 text-center text-sm font-extrabold text-slate-600 transition hover:bg-slate-200">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="rounded-2xl brand-gradient px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5">
                        Cari Penjahit
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="bg-white pb-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if($tailors->isNotEmpty())
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm font-semibold text-slate-500">
                    Menampilkan <span class="font-black text-tailor-deep">{{ $tailors->firstItem() }}-{{ $tailors->lastItem() }}</span>
                    dari <span class="font-black text-tailor-deep">{{ $tailors->total() }}</span> penjahit
                </p>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-tailor-purple/55">Hasil Pencarian</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($tailors as $tailor)
                    @php
                        $profile = $tailor->tailorProfile;
                        $shopName = $profile->shop_name ?? $tailor->name ?? 'TailorTrack';
                        $words = preg_split('/\s+/', trim($shopName));
                        $initials = strtoupper(substr($words[0] ?? 'T', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        $avgRating = round($tailor->reviews_received_avg_rating ?? 0, 1);
                        $reviewCount = $tailor->reviews_received_count ?? 0;
                    @endphp

                    <a href="{{ route('tailors.show', $tailor) }}" class="group overflow-hidden rounded-3xl border border-tailor-purple/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="h-2 gold-gradient"></div>
                        <div class="p-5">
                            <div class="flex gap-4">
                                @if($profile && $profile->photo)
                                    <img src="{{ Storage::url($profile->photo) }}" alt="{{ $shopName }}" class="h-16 w-16 shrink-0 rounded-2xl object-cover ring-4 ring-tailor-soft">
                                @else
                                    <div class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl brand-gradient text-xl font-black text-white ring-4 ring-tailor-soft">
                                        {{ $initials }}
                                    </div>
                                @endif

                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="truncate text-lg font-black text-tailor-deep">{{ $shopName }}</h3>
                                            <p class="mt-1 truncate text-sm font-semibold text-slate-500">{{ $tailor->name }}</p>
                                        </div>
                                        @if($profile && $profile->is_verified)
                                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-tailor-soft text-tailor-purple">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-7.25 7.25a1 1 0 01-1.414 0l-3.25-3.25a1 1 0 011.414-1.414l2.543 2.543 6.543-6.543a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="rounded-full px-3 py-1 text-xs font-black {{ $profile && $profile->is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $profile && $profile->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                        @if($profile && $profile->specialization)
                                            <span class="rounded-full bg-tailor-soft px-3 py-1 text-xs font-black text-tailor-purple">{{ $profile->specialization }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <p class="mt-5 line-clamp-2 text-sm leading-7 text-slate-500">
                                {{ $profile->description ?? 'Siap membantu membuat pakaian custom sesuai kebutuhan, ukuran, dan referensi desain pelanggan.' }}
                            </p>

                            <div class="mt-5 grid grid-cols-3 gap-2">
                                <div class="rounded-2xl bg-tailor-cream p-3">
                                    <p class="text-[11px] font-bold text-slate-400">Rating</p>
                                    <p class="mt-1 text-sm font-black text-tailor-deep">{{ $avgRating > 0 ? $avgRating : '-' }}</p>
                                </div>
                                <div class="rounded-2xl bg-tailor-cream p-3">
                                    <p class="text-[11px] font-bold text-slate-400">Portfolio</p>
                                    <p class="mt-1 text-sm font-black text-tailor-deep">{{ $tailor->portfolios_count ?? 0 }}</p>
                                </div>
                                <div class="rounded-2xl bg-tailor-cream p-3">
                                    <p class="text-[11px] font-bold text-slate-400">Order</p>
                                    <p class="mt-1 text-sm font-black text-tailor-deep">{{ $tailor->tailor_orders_count ?? 0 }}</p>
                                </div>
                            </div>

                            <div class="mt-5 flex items-center justify-between gap-3">
                                <span class="text-xs font-bold text-slate-400">{{ $reviewCount }} ulasan</span>
                                <span class="inline-flex items-center gap-2 rounded-2xl bg-tailor-purple px-4 py-2.5 text-sm font-extrabold text-white transition group-hover:bg-tailor-deep">
                                    Lihat Profil
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($tailors->hasPages())
                <div class="mt-10 flex justify-center">
                    <div class="rounded-3xl border border-tailor-purple/10 bg-white p-3 shadow-sm">
                        {{ $tailors->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="rounded-3xl border border-dashed border-tailor-purple/20 bg-tailor-cream p-10 text-center sm:p-14">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-white text-tailor-purple shadow-sm">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2a5 5 0 00-10 0v2m5-10a3 3 0 100-6 3 3 0 000 6z"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-black text-tailor-deep">
                    {{ request()->hasAny(['search', 'skill', 'min_rating', 'sort']) ? 'Penjahit tidak ditemukan' : 'Belum ada penjahit' }}
                </h2>
                <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-500">
                    {{ request()->hasAny(['search', 'skill', 'min_rating', 'sort']) ? 'Coba ubah kata kunci atau filter pencarian.' : 'Data penjahit akan tampil setelah profil penjahit tersedia.' }}
                </p>
                <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
                    @if(request()->hasAny(['search', 'skill', 'min_rating', 'sort']))
                        <a href="{{ route('tailors.index') }}" class="rounded-2xl bg-white px-5 py-3 text-sm font-extrabold text-tailor-purple shadow-sm">
                            Reset Filter
                        </a>
                    @else
                        <a href="{{ route('landing') }}" class="rounded-2xl bg-white px-5 py-3 text-sm font-extrabold text-tailor-purple shadow-sm">
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('register') }}" class="rounded-2xl brand-gradient px-5 py-3 text-sm font-extrabold text-white shadow-soft">
                            Daftar Sebagai Penjahit
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
