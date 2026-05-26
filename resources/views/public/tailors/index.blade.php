@extends('layouts.customer')

@section('title', 'Daftar Penjahit – TailorTrack')
@section('fullwidth', true)
@section('content')

{{-- =====================================================================
     PAGE HEADER
     ===================================================================== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 text-white">
    {{-- Background decoration --}}
    <div class="absolute inset-0 pointer-events-none select-none">
        <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-purple-500/15 blur-3xl"></div>
        <svg class="absolute inset-0 w-full h-full opacity-[0.04]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="header-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#header-grid)" />
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-indigo-200 text-sm mb-6">
            <a href="{{ route('landing') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-medium">Penjahit</span>
        </nav>

        <div class="max-w-2xl">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 leading-tight">
                Daftar Penjahit
                <span class="block text-yellow-300">Tersedia</span>
            </h1>
            <p class="text-indigo-100 text-lg leading-relaxed">
                Temukan penjahit profesional yang sesuai dengan kebutuhan dan selera Anda. Semua penjahit telah melalui proses seleksi ketat.
            </p>
        </div>

        {{-- Stats summary --}}
        <div class="mt-8 flex flex-wrap gap-6 text-sm">
            <div class="flex items-center gap-2 text-indigo-100">
                <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span><strong class="text-white">{{ $tailors->total() }}</strong> penjahit tersedia</span>
            </div>
            <div class="flex items-center gap-2 text-indigo-100">
                <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span>Semua <strong class="text-white">terverifikasi</strong></span>
            </div>
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 48L1440 48L1440 16C1200 48 900 0 720 16C540 32 240 0 0 16L0 48Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- =====================================================================
     MAIN CONTENT
     ===================================================================== --}}
<section class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Search and skill filters --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 mb-8">
            <form method="GET" action="{{ route('tailors.index') }}" class="space-y-5">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">
                    <div class="lg:col-span-5 relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama toko, penjahit, atau keahlian..."
                            class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                    </div>

                    <div class="lg:col-span-3">
                        <select name="skill" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Semua Keahlian</option>
                            @foreach($skillOptions as $skill)
                                <option value="{{ $skill }}" {{ request('skill') === $skill ? 'selected' : '' }}>
                                    {{ $skill }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="lg:col-span-2">
                        <select name="min_rating" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Semua Rating</option>
                            <option value="4" {{ request('min_rating') === '4' ? 'selected' : '' }}>Rating 4+</option>
                            <option value="3" {{ request('min_rating') === '3' ? 'selected' : '' }}>Rating 3+</option>
                        </select>
                    </div>

                    <div class="lg:col-span-2">
                        <select name="sort" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Terbaru</option>
                            <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Paling Banyak Order</option>
                            <option value="portfolio" {{ request('sort') === 'portfolio' ? 'selected' : '' }}>Portfolio Terbanyak</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-wrap gap-2">
                        @foreach(array_slice($skillOptions, 0, 7) as $skill)
                            <a href="{{ route('tailors.index', array_filter(array_merge(request()->except('page'), ['skill' => $skill]))) }}"
                               class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold transition-colors {{ request('skill') === $skill ? 'bg-indigo-600 text-white' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100' }}">
                                {{ $skill }}
                            </a>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-2">
                        @if(request()->hasAny(['search', 'skill', 'min_rating', 'sort']))
                            <a href="{{ route('tailors.index') }}"
                               class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-semibold hover:bg-slate-200 transition-colors">
                                Reset
                            </a>
                        @endif
                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold hover:opacity-90 transition-opacity">
                            Cari Penjahit
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($tailors->isNotEmpty())

            {{-- Result count --}}
            <div class="flex items-center justify-between mb-8">
                <p class="text-slate-600 text-sm">
                    Menampilkan
                    <span class="font-semibold text-slate-800">{{ $tailors->firstItem() }}–{{ $tailors->lastItem() }}</span>
                    dari <span class="font-semibold text-slate-800">{{ $tailors->total() }}</span> penjahit
                </p>
            </div>

            {{-- Tailor grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @foreach($tailors as $tailor)

                {{-- Derive initials for avatar fallback --}}
                @php
                    $shopName = $tailor->tailorProfile->shop_name ?? $tailor->name ?? 'T';
                    $words    = explode(' ', trim($shopName));
                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                @endphp

                <a href="{{ route('tailors.show', $tailor) }}"
                   class="block bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-all duration-200 hover:-translate-y-1 group">

                    {{-- Top accent bar --}}
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

                    <div class="p-6">

                        {{-- Avatar + header --}}
                        <div class="flex items-start gap-4 mb-5">
                            {{-- Avatar --}}
                            <div class="relative flex-shrink-0">
                                @if($tailor->tailorProfile && $tailor->tailorProfile->photo)
                                    <img src="{{ Storage::url($tailor->tailorProfile->photo) }}"
                                         alt="{{ $shopName }}"
                                         class="w-18 h-18 w-[72px] h-[72px] rounded-xl object-cover ring-2 ring-indigo-100 group-hover:ring-indigo-300 transition-all">
                                @else
                                    <div class="w-[72px] h-[72px] rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-xl ring-2 ring-indigo-100 group-hover:ring-indigo-300 transition-all select-none">
                                        {{ $initials }}
                                    </div>
                                @endif
                                {{-- Availability indicator --}}
                                @if($tailor->tailorProfile && $tailor->tailorProfile->is_available)
                                    <span class="absolute -bottom-1 -right-1 flex items-center gap-1 bg-emerald-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none shadow">
                                        ✓
                                    </span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-1.5 flex-wrap mb-0.5">
                                    <h3 class="font-bold text-slate-800 text-base leading-tight truncate max-w-[150px]">
                                        {{ $shopName }}
                                    </h3>
                                    @if($tailor->tailorProfile && $tailor->tailorProfile->is_verified)
                                        <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-slate-500 text-sm truncate">{{ $tailor->name }}</p>

                                {{-- Availability badge --}}
                                @if($tailor->tailorProfile && $tailor->tailorProfile->is_available)
                                    <span class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 mt-1.5 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Specialization --}}
                        @if($tailor->tailorProfile && $tailor->tailorProfile->specialization)
                            <div class="mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $tailor->tailorProfile->specialization }}
                                </span>
                            </div>
                        @endif

                        {{-- Rating Row --}}
                        @php
                            $avgRating  = round($tailor->reviews_received_avg_rating ?? 0, 1);
                            $revCount   = $tailor->reviews_received_count ?? 0;
                        @endphp
                        <div class="flex items-center gap-1.5 mb-4">
                            @if($avgRating > 0)
                                <div class="flex items-center gap-0.5">
                                    @for($s = 1; $s <= 5; $s++)
                                        <svg class="w-4 h-4 {{ $s <= round($avgRating) ? 'text-yellow-400' : 'text-slate-200' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-bold text-yellow-600">{{ $avgRating }}</span>
                                <span class="text-xs text-slate-400">({{ $revCount }} ulasan)</span>
                            @else
                                <div class="flex items-center gap-0.5">
                                    @for($s = 1; $s <= 5; $s++)
                                        <svg class="w-4 h-4 text-slate-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xs text-slate-400">Belum ada ulasan</span>
                            @endif
                        </div>

                        {{-- Meta stats: 3 kolom --}}
                        <div class="grid grid-cols-3 gap-2 mb-5">
                            {{-- Experience --}}
                            <div class="bg-slate-50 rounded-lg p-2.5 text-center">
                                <p class="text-xs text-slate-400 mb-0.5">Pengalaman</p>
                                <p class="text-sm font-bold text-slate-700">
                                    @if($tailor->tailorProfile && $tailor->tailorProfile->experience_years)
                                        {{ $tailor->tailorProfile->experience_years }} thn
                                    @else
                                        <span class="font-normal text-slate-400">—</span>
                                    @endif
                                </p>
                            </div>
                            {{-- Portfolio --}}
                            <div class="bg-slate-50 rounded-lg p-2.5 text-center">
                                <p class="text-xs text-slate-400 mb-0.5">Portfolio</p>
                                <p class="text-sm font-bold text-slate-700">
                                    {{ $tailor->portfolios_count ?? 0 }} karya
                                </p>
                            </div>
                            {{-- Total Orders --}}
                            <div class="bg-indigo-50 rounded-lg p-2.5 text-center">
                                <p class="text-xs text-indigo-400 mb-0.5">Pesanan</p>
                                <p class="text-sm font-bold text-indigo-700">
                                    {{ $tailor->tailor_orders_count ?? 0 }} order
                                </p>
                            </div>
                        </div>

                        {{-- CTA Button --}}
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center px-4 py-2.5 rounded-lg font-semibold text-sm group-hover:opacity-90 transition-opacity">
                            Lihat Profil & Pesan
                        </div>
                    </div>
                </a>

                @endforeach
            </div>

            {{-- Pagination --}}
            @if($tailors->hasPages())
                <div class="flex justify-center">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-3">
                        {{ $tailors->links() }}
                    </div>
                </div>
            @endif

        @else

            {{-- Empty state --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-16 text-center">
                <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                @if(request()->hasAny(['search', 'skill', 'min_rating', 'sort']))
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Penjahit Tidak Ditemukan</h3>
                    <p class="text-slate-500 mb-8 max-w-md mx-auto">
                        Tidak ada penjahit yang cocok dengan filter pencarian saat ini. Coba gunakan kata kunci atau keahlian lain.
                    </p>
                @else
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Penjahit</h3>
                    <p class="text-slate-500 mb-8 max-w-md mx-auto">
                        Saat ini belum ada penjahit yang terdaftar. Silakan cek kembali nanti atau daftar sebagai penjahit.
                    </p>
                @endif
                <div class="flex flex-wrap justify-center gap-4">
                    @if(request()->hasAny(['search', 'skill', 'min_rating', 'sort']))
                        <a href="{{ route('tailors.index') }}"
                           class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors">
                            Reset Filter
                        </a>
                    @else
                        <a href="{{ route('landing') }}"
                           class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity">
                            Daftar Sebagai Penjahit
                        </a>
                    @endif
                </div>
            </div>

        @endif

    </div>
</section>

@endsection
