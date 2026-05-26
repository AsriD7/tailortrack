@extends('layouts.customer')

@section('title', ($tailor->tailorProfile->shop_name ?? $tailor->name) . ' – TailorTrack')
@section('fullwidth', true)
@section('content')

{{-- =====================================================================
     PROFILE HERO / HEADER
     ===================================================================== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 text-white">
    {{-- Background decoration --}}
    <div class="absolute inset-0 pointer-events-none select-none">
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute bottom-0 -left-10 w-64 h-64 rounded-full bg-purple-500/20 blur-3xl"></div>
        <svg class="absolute inset-0 w-full h-full opacity-[0.04]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="profile-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#profile-grid)" />
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-indigo-200 text-sm mb-8">
            <a href="{{ route('landing') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('tailors.index') }}" class="hover:text-white transition-colors">Penjahit</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-medium truncate max-w-[180px]">
                {{ $tailor->tailorProfile->shop_name ?? $tailor->name }}
            </span>
        </nav>

        {{-- Profile header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
            {{-- Avatar --}}
            @php
                $shopName = $tailor->tailorProfile->shop_name ?? $tailor->name ?? 'T';
                $words    = explode(' ', trim($shopName));
                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
            @endphp

            <div class="relative flex-shrink-0">
                @if($tailor->tailorProfile && $tailor->tailorProfile->photo)
                    <img src="{{ Storage::url($tailor->tailorProfile->photo) }}"
                         alt="{{ $shopName }}"
                         class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl object-cover ring-4 ring-white/30 shadow-xl">
                @else
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-black text-4xl ring-4 ring-white/30 shadow-xl select-none">
                        {{ $initials }}
                    </div>
                @endif
                {{-- Online indicator --}}
                @if($tailor->tailorProfile && $tailor->tailorProfile->is_available)
                    <div class="absolute -bottom-2 -right-2 flex items-center gap-1.5 bg-emerald-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        Tersedia
                    </div>
                @else
                    <div class="absolute -bottom-2 -right-2 flex items-center gap-1.5 bg-slate-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg">
                        <span class="w-2 h-2 rounded-full bg-white/60"></span>
                        Sibuk
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight">{{ $shopName }}</h1>
                    @if($tailor->tailorProfile && $tailor->tailorProfile->is_verified)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-sm font-semibold border border-white/30">
                            <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Terverifikasi
                        </span>
                    @endif
                </div>

                <p class="text-indigo-200 text-lg mb-4">{{ $tailor->name }}</p>

                <div class="flex flex-wrap gap-3">
                    @if($tailor->tailorProfile && $tailor->tailorProfile->specialization)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm text-sm font-semibold border border-white/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ $tailor->tailorProfile->specialization }}
                        </span>
                    @endif

                    @if($tailor->tailorProfile && $tailor->tailorProfile->experience_years)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm text-sm font-semibold border border-white/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $tailor->tailorProfile->experience_years }} Tahun Pengalaman
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm text-sm font-semibold border border-white/20">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                        </svg>
                        {{ $tailor->portfolios->count() }} Portfolio
                    </span>

                    {{-- Rating chip --}}
                    @if($reviewCount > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-yellow-400/20 backdrop-blur-sm text-sm font-bold border border-yellow-300/40 text-yellow-200">
                            <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ number_format($avgRating, 1) }} ({{ $reviewCount }} ulasan)
                        </span>
                    @endif

                    {{-- Order count chip --}}
                    @php $totalOrders = $tailor->tailorOrders()->count(); @endphp
                    @if($totalOrders > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm text-sm font-semibold border border-white/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                            </svg>
                            {{ $totalOrders }} Pesanan
                        </span>
                    @endif
                </div>
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
     MAIN CONTENT + SIDEBAR
     ===================================================================== --}}
<section class="bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- =========================================================
                 LEFT / MAIN COLUMN
                 ========================================================= --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- About section --}}
                @if($tailor->tailorProfile && $tailor->tailorProfile->description)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Tentang Penjahit
                    </h2>
                    <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $tailor->tailorProfile->description }}</p>
                </div>
                @endif

                {{-- Address & Contact --}}
                @if($tailor->tailorProfile && ($tailor->tailorProfile->address || $tailor->tailorProfile->phone || $tailor->tailorProfile->city))
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        Lokasi & Kontak
                    </h2>

                    <div class="space-y-4">
                        @if($tailor->tailorProfile->address || $tailor->tailorProfile->city)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-0.5">Alamat</p>
                                <p class="text-sm text-slate-700">
                                    {{ $tailor->tailorProfile->address }}
                                    @if($tailor->tailorProfile->city)
                                        {{ $tailor->tailorProfile->address ? ', ' : '' }}{{ $tailor->tailorProfile->city }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($tailor->tailorProfile->phone)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-0.5">Telepon / WhatsApp</p>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $tailor->tailorProfile->phone) }}"
                                   target="_blank" rel="noopener"
                                   class="text-sm text-indigo-600 font-medium hover:text-indigo-800 transition-colors">
                                    {{ $tailor->tailorProfile->phone }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($tailor->email)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-0.5">Email</p>
                                <p class="text-sm text-slate-700">{{ $tailor->email }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Portfolio grid --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            Portfolio
                        </h2>
                        <span class="inline-flex px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                            {{ $tailor->portfolios->count() }} karya
                        </span>
                    </div>

                    @if($tailor->portfolios->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($tailor->portfolios as $portfolio)
                            <div class="group rounded-2xl overflow-hidden bg-white border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                                <a href="{{ $portfolio->imageUrl }}" target="_blank" rel="noopener" class="block relative aspect-[4/3] overflow-hidden bg-slate-100">
                                    @if($portfolio->image)
                                        <img src="{{ $portfolio->imageUrl }}"
                                             alt="{{ $portfolio->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-gradient-to-br from-slate-50 to-slate-100">
                                            <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-xs">No image</span>
                                        </div>
                                    @endif

                                    @if($portfolio->is_featured)
                                        <span class="absolute top-3 left-3 inline-flex px-2.5 py-1 rounded-full bg-amber-400 text-amber-950 text-xs font-bold shadow-sm">
                                            Unggulan
                                        </span>
                                    @endif
                                </a>
                                <div class="p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <h3 class="font-bold text-slate-800 text-sm leading-snug">{{ $portfolio->title }}</h3>
                                        @if($portfolio->category)
                                            <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-[11px] font-semibold">
                                                {{ $portfolio->category }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($portfolio->description)
                                        <p class="mt-2 text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $portfolio->description }}</p>
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
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-slate-400">
                            <svg class="w-14 h-14 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="font-medium text-slate-500">Belum ada portfolio</p>
                            <p class="text-sm mt-1">Penjahit ini belum mengunggah portfolio.</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- =========================================================
                 RIGHT SIDEBAR
                 ========================================================= --}}
            <div class="lg:col-span-1">
                <div class="sticky top-6 space-y-5">

                    {{-- Order card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                        <div class="p-6">
                            <h3 class="font-bold text-slate-800 text-lg mb-1">Pesan Sekarang</h3>
                            <p class="text-slate-500 text-sm mb-5">Pesan langsung ke penjahit ini dengan aman melalui platform kami.</p>

                            {{-- Price hint --}}
                            @if($tailor->tailorProfile && $tailor->tailorProfile->base_price)
                                <div class="bg-indigo-50 rounded-xl p-4 mb-5">
                                    <p class="text-xs text-indigo-500 font-medium mb-1">Harga mulai dari</p>
                                    <p class="text-2xl font-extrabold text-indigo-700">
                                        Rp {{ number_format($tailor->tailorProfile->base_price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-indigo-400 mt-1">*Harga bisa bervariasi sesuai detail pesanan</p>
                                </div>
                            @else
                                <div class="bg-slate-50 rounded-xl p-4 mb-5">
                                    <p class="text-xs text-slate-400 font-medium mb-1">Harga</p>
                                    <p class="text-base font-semibold text-slate-600">Hubungi untuk penawaran</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-2 mb-5">
                                <div class="bg-slate-50 rounded-xl p-3">
                                    <p class="text-[11px] text-slate-400 font-medium">Antrean Aktif</p>
                                    <p class="text-sm font-bold text-slate-700 mt-0.5">
                                        {{ $activeOrdersCount }}{{ $tailor->tailorProfile?->max_active_orders ? ' / ' . $tailor->tailorProfile->max_active_orders : '' }}
                                    </p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-3">
                                    <p class="text-[11px] text-slate-400 font-medium">Estimasi</p>
                                    <p class="text-sm font-bold text-slate-700 mt-0.5">
                                        {{ $tailor->tailorProfile?->estimated_processing_days ? $tailor->tailorProfile->estimated_processing_days . ' hari' : 'Dikonfirmasi' }}
                                    </p>
                                </div>
                            </div>

                            @if($workingDayLabels->isNotEmpty())
                                <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-3 mb-5">
                                    <p class="text-[11px] text-indigo-500 font-medium mb-1">Hari Kerja</p>
                                    <p class="text-xs text-indigo-700 font-semibold leading-relaxed">
                                        {{ $workingDayLabels->implode(', ') }}
                                    </p>
                                </div>
                            @endif

                            @if($unavailableDates->isNotEmpty())
                                <div class="bg-red-50 border border-red-100 rounded-xl p-3 mb-5">
                                    <p class="text-[11px] text-red-500 font-medium mb-2">Tanggal Tidak Tersedia</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($unavailableDates as $date)
                                            <span class="inline-flex px-2 py-0.5 rounded-full bg-white/70 border border-red-100 text-[11px] font-semibold text-red-700">
                                                {{ $date->date->format('d M Y') }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($isAtCapacity)
                                <div class="bg-red-50 border border-red-200 rounded-xl p-3 mb-5">
                                    <p class="text-xs text-red-700 leading-relaxed">
                                        Antrean penjahit sedang penuh. Pesanan baru belum dapat dibuat saat ini.
                                    </p>
                                </div>
                            @endif

                            {{-- CTA button --}}
                            @auth
                                @if(auth()->user()->isCustomer() && !$isAtCapacity)
                                    <a href="{{ route('customer.orders.create', $tailor->id) }}"
                                       class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-3.5 rounded-xl font-bold text-sm hover:opacity-90 transition-opacity shadow-md shadow-indigo-200 mb-3">
                                        🧵 Buat Pesanan Sekarang
                                    </a>
                                @elseif(auth()->user()->isCustomer() && $isAtCapacity)
                                    <div class="block w-full text-center bg-slate-100 text-slate-400 px-4 py-3.5 rounded-xl font-bold text-sm cursor-not-allowed mb-3">
                                        Antrean Sedang Penuh
                                    </div>
                                @elseif(auth()->user()->isTailor())
                                    <div class="block w-full text-center bg-slate-100 text-slate-400 px-4 py-3.5 rounded-xl font-bold text-sm cursor-not-allowed mb-3">
                                        Hanya customer yang dapat memesan
                                    </div>
                                @else
                                    <div class="block w-full text-center bg-slate-100 text-slate-400 px-4 py-3.5 rounded-xl font-bold text-sm cursor-not-allowed mb-3">
                                        Login sebagai pelanggan untuk memesan
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-3.5 rounded-xl font-bold text-sm hover:opacity-90 transition-opacity shadow-md shadow-indigo-200 mb-3">
                                    Login untuk Memesan
                                </a>
                                <a href="{{ route('register') }}"
                                   class="block w-full text-center bg-slate-100 text-slate-700 px-4 py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-200 transition-colors">
                                    Belum punya akun? Daftar
                                </a>
                            @endauth

                            {{-- WhatsApp contact --}}
                            @if($tailor->tailorProfile && $tailor->tailorProfile->phone)
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $tailor->tailorProfile->phone) }}?text=Halo, saya tertarik dengan layanan jahit Anda di TailorTrack."
                                   target="_blank" rel="noopener"
                                   class="mt-3 flex items-center justify-center gap-2 w-full text-center bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-2.5 rounded-xl font-semibold text-sm hover:bg-emerald-100 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    Chat via WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Quick info card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <h3 class="font-bold text-slate-700 text-sm mb-4">Informasi Singkat</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Status</span>
                                @if($tailor->tailorProfile && $tailor->tailorProfile->is_available)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-50 text-red-600 text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </div>
                            @if($tailor->tailorProfile && $tailor->tailorProfile->experience_years)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Pengalaman</span>
                                <span class="font-semibold text-slate-700">{{ $tailor->tailorProfile->experience_years }} Tahun</span>
                            </div>
                            @endif
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Portfolio</span>
                                <span class="font-semibold text-slate-700">{{ $tailor->portfolios->count() }} Karya</span>
                            </div>
                            @if($tailor->tailorProfile && $tailor->tailorProfile->is_verified)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Verifikasi</span>
                                <span class="inline-flex items-center gap-1 text-indigo-600 font-semibold text-xs">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l3-3z" clip-rule="evenodd"/>
                                    </svg>
                                    Terverifikasi
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Back button --}}
                    <a href="{{ route('tailors.index') }}"
                       class="flex items-center justify-center gap-2 w-full bg-slate-100 text-slate-600 px-4 py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar Penjahit
                    </a>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================================================================
     REVIEWS SECTION
     ================================================================ --}}
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">Ulasan Pelanggan</h2>
                <p class="text-slate-500 text-sm">{{ $reviewCount }} ulasan dari pelanggan</p>
            </div>
        </div>

        @if($reviewCount > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">

            {{-- Rating Summary --}}
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-100 p-6 flex flex-col items-center justify-center text-center">
                <p class="text-6xl font-extrabold text-yellow-500 leading-none mb-1">
                    {{ number_format($avgRating, 1) }}
                </p>
                <div class="flex items-center justify-center gap-0.5 my-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($avgRating))
                            <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-slate-200" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                    @endfor
                </div>
                <p class="text-slate-500 text-sm">dari {{ $reviewCount }} ulasan</p>

                {{-- Rating breakdown bars --}}
                <div class="w-full mt-4 space-y-1.5">
                    @foreach($ratingBreakdown as $star => $data)
                    <div class="flex items-center gap-2 text-xs">
                        <span class="text-slate-500 w-3 text-right">{{ $star }}</span>
                        <svg class="w-3 h-3 text-yellow-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-yellow-400 h-2 rounded-full transition-all"
                                 style="width: {{ $data['percent'] }}%"></div>
                        </div>
                        <span class="text-slate-400 w-6 text-left">{{ $data['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Review List --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($reviews as $review)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                {{ strtoupper(substr($review->customer->name ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">{{ $review->customer->name ?? 'Pelanggan' }}</p>
                                <p class="text-slate-400 text-xs">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-0.5 shrink-0">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-200' }}"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-1.5 text-xs font-semibold text-yellow-600">{{ $review->rating_label }}</span>
                        </div>
                    </div>
                    @if($review->comment)
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-sm text-slate-700 leading-relaxed">"{{ $review->comment }}"</p>
                        </div>
                    @else
                        <p class="text-sm text-slate-400 italic">Tidak ada komentar.</p>
                    @endif
                </div>
                @endforeach

                {{-- Pagination --}}
                @if($reviews->hasPages())
                <div class="pt-2">{{ $reviews->links() }}</div>
                @endif
            </div>

        </div>
        @else
        {{-- No reviews yet --}}
        <div class="bg-slate-50 rounded-2xl border border-slate-100 p-12 text-center">
            <div class="w-16 h-16 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700 mb-1">Belum ada ulasan</h3>
            <p class="text-slate-400 text-sm max-w-xs mx-auto">Jadilah yang pertama memberikan ulasan setelah memesan dari penjahit ini!</p>
        </div>
        @endif

    </div>
</section>

@endsection
