@extends('layouts.customer')

@section('title', 'TailorTrack – Temukan Penjahit Terbaik untuk Anda')
@section('fullwidth', true)

@section('content')

{{-- =====================================================================
     HERO SECTION
     ===================================================================== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 text-white">

    {{-- Decorative background blobs --}}
    <div class="absolute inset-0 pointer-events-none select-none">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute bottom-0 -left-16 w-80 h-80 rounded-full bg-purple-500/20 blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-indigo-500/10 blur-3xl"></div>
        {{-- Grid pattern overlay --}}
        <svg class="absolute inset-0 w-full h-full opacity-[0.04]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="hero-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-grid)" />
        </svg>
        {{-- Floating decorative shapes --}}
        <div class="absolute top-20 right-[10%] w-20 h-20 border border-white/20 rounded-2xl rotate-12 hidden lg:block"></div>
        <div class="absolute top-40 right-[20%] w-10 h-10 border border-white/20 rounded-full hidden lg:block"></div>
        <div class="absolute bottom-24 left-[15%] w-14 h-14 border border-white/20 rounded-xl -rotate-6 hidden lg:block"></div>
        <div class="absolute top-32 left-[8%] w-8 h-8 bg-white/10 rounded-lg rotate-45 hidden lg:block"></div>
        {{-- Scissors icon decoration --}}
        <svg class="absolute bottom-16 right-[8%] w-24 h-24 text-white/10 hidden lg:block" fill="currentColor" viewBox="0 0 24 24">
            <path d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .89 2 2-.9 2-2 2zm6-7.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM19 3l-6 6 2 2 7-7V3h-3z"/>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-36">
        <div class="max-w-3xl">
            {{-- Badge --}}
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm text-sm font-medium mb-6 border border-white/20">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                </span>
                Platform Marketplace Jahit #1 di Indonesia
            </span>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight mb-6">
                Temukan Penjahit
                <span class="block bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                    Terbaik untuk Anda
                </span>
            </h1>

            <p class="text-lg sm:text-xl text-indigo-100 leading-relaxed mb-10 max-w-2xl">
                TailorTrack menghubungkan Anda dengan penjahit profesional dan berpengalaman.
                Pesan baju custom, pantau progress, dan dapatkan hasil terbaik — semua dalam satu platform.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('tailors.index') }}"
                   class="inline-flex items-center gap-2 bg-white text-indigo-700 px-6 py-3.5 rounded-xl font-bold text-base shadow-lg shadow-indigo-900/30 hover:bg-indigo-50 transition-all duration-200 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    Cari Penjahit
                </a>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 bg-transparent text-white border-2 border-white/60 px-6 py-3.5 rounded-xl font-bold text-base hover:bg-white/10 hover:border-white transition-all duration-200 hover:-translate-y-0.5 backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM3 20a6 6 0 0 1 12 0v1H3v-1z"/>
                    </svg>
                    Daftar Gratis
                </a>
            </div>

            {{-- Trust indicators --}}
            <div class="mt-10 flex items-center gap-6 text-indigo-200 text-sm">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Gratis Daftar
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Penjahit Terverifikasi
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Tracking Real-time
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 60L1440 60L1440 20C1200 60 900 0 720 20C540 40 240 0 0 20L0 60Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- =====================================================================
     STATS BAR
     ===================================================================== --}}
<section class="bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            {{-- Stat 1 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-slate-800">100+</p>
                    <p class="text-sm font-medium text-slate-500 mt-0.5">Penjahit Terpercaya</p>
                </div>
            </div>

            {{-- Stat 2 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-slate-800">1.000+</p>
                    <p class="text-sm font-medium text-slate-500 mt-0.5">Pesanan Selesai</p>
                </div>
            </div>

            {{-- Stat 3 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-slate-800">⚡ Cepat</p>
                    <p class="text-sm font-medium text-slate-500 mt-0.5">Layanan Cepat & Berkualitas</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =====================================================================
     CARA KERJA
     ===================================================================== --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section header --}}
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-sm font-semibold mb-4">
                Mudah & Cepat
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 mb-4">Cara Kerja TailorTrack</h2>
            <p class="text-slate-500 text-lg max-w-xl mx-auto">Tiga langkah mudah untuk mendapatkan pakaian impian Anda dari penjahit terpercaya.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">

            {{-- Connector line (desktop) --}}
            <div class="hidden md:block absolute top-12 left-1/3 right-1/3 h-0.5 bg-gradient-to-r from-indigo-200 via-indigo-400 to-purple-200 z-0"></div>

            {{-- Step 1 --}}
            <div class="relative bg-slate-50 rounded-2xl p-8 border border-slate-100 hover:shadow-md transition-shadow duration-200 z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center mb-6 shadow-lg shadow-indigo-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </div>
                <span class="absolute top-6 right-6 text-6xl font-black text-slate-100 select-none">1</span>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Pilih Penjahit</h3>
                <p class="text-slate-500 leading-relaxed">Browse dan pilih penjahit sesuai kebutuhan, spesialisasi, dan anggaran Anda dari ratusan penjahit terverifikasi.</p>
            </div>

            {{-- Step 2 --}}
            <div class="relative bg-slate-50 rounded-2xl p-8 border border-slate-100 hover:shadow-md transition-shadow duration-200 z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center mb-6 shadow-lg shadow-purple-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="absolute top-6 right-6 text-6xl font-black text-slate-100 select-none">2</span>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Buat Pesanan</h3>
                <p class="text-slate-500 leading-relaxed">Isi form pesanan dengan detail ukuran, catatan khusus, dan unggah gambar referensi pakaian yang Anda inginkan.</p>
            </div>

            {{-- Step 3 --}}
            <div class="relative bg-slate-50 rounded-2xl p-8 border border-slate-100 hover:shadow-md transition-shadow duration-200 z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center mb-6 shadow-lg shadow-indigo-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="absolute top-6 right-6 text-6xl font-black text-slate-100 select-none">3</span>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Pantau Progress</h3>
                <p class="text-slate-500 leading-relaxed">Tracking status pesanan secara real-time. Terima notifikasi setiap ada update dari penjahit hingga pesanan selesai.</p>
            </div>

        </div>
    </div>
</section>

{{-- =====================================================================
     PENJAHIT UNGGULAN
     ===================================================================== --}}
<section class="bg-slate-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-end justify-between mb-12">
            <div>
                <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-sm font-semibold mb-4">
                    Pilihan Terbaik
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800">Penjahit Unggulan</h2>
                <p class="text-slate-500 mt-2">Penjahit terpilih dengan ulasan terbaik dari pelanggan kami.</p>
            </div>
            <a href="{{ route('tailors.index') }}"
               class="hidden sm:inline-flex items-center gap-2 text-indigo-600 font-semibold text-sm hover:text-indigo-800 transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($tailors->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tailors as $tailor)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
                    {{-- Top gradient bar --}}
                    <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

                    <div class="p-6">
                        {{-- Profile photo --}}
                        <div class="flex items-start gap-4 mb-5">
                            <div class="relative flex-shrink-0">
                                @if($tailor->tailorProfile && $tailor->tailorProfile->photo)
                                    <img src="{{ Storage::url($tailor->tailorProfile->photo) }}"
                                         alt="{{ $tailor->tailorProfile->shop_name }}"
                                         class="w-16 h-16 rounded-xl object-cover ring-2 ring-indigo-100">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xl font-bold ring-2 ring-indigo-100">
                                        {{ strtoupper(substr($tailor->tailorProfile->shop_name ?? $tailor->name, 0, 1)) }}
                                    </div>
                                @endif
                                @if($tailor->tailorProfile && $tailor->tailorProfile->is_available)
                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 rounded-full ring-2 ring-white"></span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="font-bold text-slate-800 text-base leading-tight truncate">
                                        {{ $tailor->tailorProfile->shop_name ?? $tailor->name }}
                                    </h3>
                                    @if($tailor->tailorProfile && $tailor->tailorProfile->is_verified)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold flex-shrink-0">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Verified
                                        </span>
                                    @endif
                                </div>
                                <p class="text-slate-500 text-sm mt-0.5 truncate">{{ $tailor->name }}</p>
                            </div>
                        </div>

                        {{-- Specialization --}}
                        @if($tailor->tailorProfile && $tailor->tailorProfile->specialization)
                            <div class="mb-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-semibold">
                                    {{ $tailor->tailorProfile->specialization }}
                                </span>
                            </div>
                        @endif

                        {{-- Stats --}}
                        <div class="flex items-center gap-4 text-sm text-slate-500 mb-5">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $tailor->portfolios_count ?? $tailor->portfolios->count() }} portfolio</span>
                            </div>
                        </div>

                        {{-- Action button --}}
                        <a href="{{ route('tailors.show', $tailor) }}"
                           class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity">
                            Lihat Profil
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-slate-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <p class="font-medium">Belum ada penjahit tersedia</p>
            </div>
        @endif

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('tailors.index') }}"
               class="inline-flex items-center gap-2 text-indigo-600 font-semibold text-sm hover:text-indigo-800">
                Lihat Semua Penjahit
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</section>

{{-- =====================================================================
     PORTFOLIO TERBARU
     ===================================================================== --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 rounded-full bg-purple-50 text-purple-700 text-sm font-semibold mb-4">
                Karya Terbaru
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 mb-4">Portfolio Terbaru</h2>
            <p class="text-slate-500 text-lg max-w-xl mx-auto">Lihat hasil karya terbaik dari penjahit-penjahit kami yang berpengalaman.</p>
        </div>

        @if($portfolios->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($portfolios as $portfolio)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 group">
                    {{-- Portfolio image --}}
                    <div class="aspect-[4/3] overflow-hidden bg-slate-100 relative">
                        @if($portfolio->image)
                            <img src="{{ Storage::url($portfolio->image) }}"
                                 alt="{{ $portfolio->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm">Tidak ada foto</span>
                            </div>
                        @endif
                        {{-- Category badge overlay --}}
                        @if($portfolio->category)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-black/50 backdrop-blur-sm text-white text-xs font-semibold">
                                    {{ $portfolio->category }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <h3 class="font-bold text-slate-800 mb-1 line-clamp-1">{{ $portfolio->title }}</h3>
                        @if($portfolio->tailor)
                            <p class="text-sm text-slate-500 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name }}
                            </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 text-slate-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="font-medium">Belum ada portfolio tersedia</p>
            </div>
        @endif

    </div>
</section>

{{-- =====================================================================
     HARGA TERJANGKAU
     ===================================================================== --}}
<section class="bg-slate-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold mb-4">
                Harga Transparan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 mb-4">Harga Terjangkau</h2>
            <p class="text-slate-500 text-lg max-w-xl mx-auto">Berbagai pilihan layanan dengan harga yang transparan dan sesuai anggaran Anda.</p>
        </div>

        @if($priceLists->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($priceLists->take(6) as $priceList)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        @if($priceList->category)
                            <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                                {{ $priceList->category }}
                            </span>
                        @endif
                    </div>
                    <h3 class="font-bold text-slate-800 mb-1">{{ $priceList->name }}</h3>
                    @if($priceList->description)
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $priceList->description }}</p>
                    @endif
                    <div class="pt-3 border-t border-slate-100">
                        <p class="text-xs text-slate-400 mb-0.5">Harga mulai dari</p>
                        <p class="text-xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Rp {{ number_format($priceList->base_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('price-lists.index') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:opacity-90 transition-opacity shadow-md shadow-indigo-200">
                    Lihat Semua Harga
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-16 text-slate-400">
                <p class="font-medium">Informasi harga belum tersedia</p>
            </div>
        @endif

    </div>
</section>

{{-- =====================================================================
     CTA SECTION
     ===================================================================== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 text-white py-20">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 pointer-events-none select-none">
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full bg-purple-500/20 blur-3xl"></div>
        <svg class="absolute inset-0 w-full h-full opacity-[0.04]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="cta-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cta-grid)" />
        </svg>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-20 h-20 rounded-2xl bg-white/15 backdrop-blur-sm border border-white/20 flex items-center justify-center mx-auto mb-8">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
        </div>

        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-6 leading-tight">
            Siap Mulai Memesan?
        </h2>
        <p class="text-lg sm:text-xl text-indigo-100 mb-10 max-w-2xl mx-auto leading-relaxed">
            Bergabunglah dengan ribuan pelanggan puas yang telah mempercayakan kebutuhan pakaian mereka kepada penjahit terbaik di TailorTrack.
        </p>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2 bg-white text-indigo-700 px-8 py-4 rounded-xl font-bold text-base shadow-lg shadow-indigo-900/30 hover:bg-indigo-50 transition-all duration-200 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Daftar Sekarang — Gratis!
            </a>
            <a href="{{ route('tailors.index') }}"
               class="inline-flex items-center gap-2 bg-transparent text-white border-2 border-white/60 px-8 py-4 rounded-xl font-bold text-base hover:bg-white/10 hover:border-white transition-all duration-200 hover:-translate-y-0.5 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
                Browse Penjahit
            </a>
        </div>
    </div>
</section>

@endsection
