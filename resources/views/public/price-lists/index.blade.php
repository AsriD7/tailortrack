@extends('layouts.guest')

@section('title', 'Daftar Harga Layanan – TailorTrack')

@section('content')

{{-- =====================================================================
     PAGE HEADER
     ===================================================================== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 text-white">
    {{-- Background decoration --}}
    <div class="absolute inset-0 pointer-events-none select-none">
        <div class="absolute -top-20 -right-24 w-96 h-96 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute bottom-0 -left-16 w-72 h-72 rounded-full bg-purple-500/20 blur-3xl"></div>
        <svg class="absolute inset-0 w-full h-full opacity-[0.04]" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="price-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#price-grid)" />
        </svg>
        {{-- Decorative tag icon --}}
        <svg class="absolute right-12 top-12 w-32 h-32 text-white/10 hidden lg:block" fill="currentColor" viewBox="0 0 24 24">
            <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-indigo-200 text-sm mb-6">
            <a href="{{ route('landing') }}" class="hover:text-white transition-colors">Beranda</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-white font-medium">Daftar Harga</span>
        </nav>

        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur-sm text-sm font-medium mb-5 border border-white/20">
                <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
                Harga Transparan & Terjangkau
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 leading-tight">
                Daftar Harga
                <span class="text-yellow-300">Layanan</span>
            </h1>
            <p class="text-indigo-100 text-lg leading-relaxed">
                Temukan layanan jahit sesuai kebutuhan Anda dengan harga yang transparan. Semua harga merupakan harga dasar per item.
            </p>
        </div>

        {{-- Quick stats --}}
        <div class="mt-8 flex flex-wrap gap-6 text-sm">
            <div class="flex items-center gap-2 text-indigo-100">
                <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span><strong class="text-white">{{ $priceLists->count() }}</strong> layanan tersedia</span>
            </div>
            <div class="flex items-center gap-2 text-indigo-100">
                <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <span><strong class="text-white">{{ count($grouped) }}</strong> kategori</span>
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
<section class="bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- SIZE SURCHARGE NOTICE --}}
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-10 flex gap-4">
            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-amber-800 mb-1.5">Informasi Biaya Tambahan Ukuran</h3>
                <p class="text-amber-700 text-sm mb-3">
                    Harga di bawah adalah harga dasar untuk ukuran <strong>S dan M</strong>. Untuk ukuran lebih besar, dikenakan biaya tambahan:
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 text-sm font-semibold">
                        <span class="font-black">L</span>
                        <span class="text-amber-600">+</span>
                        Rp 5.000
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 text-sm font-semibold">
                        <span class="font-black">XL</span>
                        <span class="text-amber-600">+</span>
                        Rp 10.000
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 text-sm font-semibold">
                        <span class="font-black">XXL</span>
                        <span class="text-amber-600">+</span>
                        Rp 15.000
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-100 text-amber-800 text-sm font-semibold">
                        <span class="font-black">Custom</span>
                        <span class="text-amber-600">+</span>
                        Rp 20.000
                    </span>
                </div>
            </div>
        </div>

        @if($priceLists->isNotEmpty())

            {{-- ============================================================
                 GROUPED TABLES BY CATEGORY
                 ============================================================ --}}
            @if(!empty($grouped) && count($grouped) > 0)

                @foreach($grouped as $category => $items)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">

                    {{-- Category header --}}
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3 bg-gradient-to-r from-slate-50 to-white">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4.5 h-4.5 w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-800 text-base">
                                {{ $category ?: 'Layanan Umum' }}
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">{{ count($items) }} layanan</p>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-8">#</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Layanan</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Deskripsi</th>
                                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga Dasar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($items as $index => $priceList)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-6 py-4 text-slate-400 text-xs">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-slate-800">{{ $priceList->name }}</div>
                                        {{-- Show description on mobile --}}
                                        @if($priceList->description)
                                            <div class="text-xs text-slate-400 mt-0.5 sm:hidden">{{ Str::limit($priceList->description, 60) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        <span class="text-slate-500 text-sm">
                                            {{ $priceList->description ?: '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-baseline gap-1">
                                            <span class="text-xs font-medium text-slate-400">Rp</span>
                                            <span class="font-extrabold text-indigo-700 text-base">
                                                {{ number_format($priceList->base_price, 0, ',', '.') }}
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                @endforeach

            @else
                {{-- Flat list if no grouping --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-bold text-slate-800">Semua Layanan</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-8">#</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Layanan</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Kategori</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Deskripsi</th>
                                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga Dasar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($priceLists as $index => $priceList)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-6 py-4 text-slate-400 text-xs">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-slate-800">{{ $priceList->name }}</div>
                                    </td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @if($priceList->category)
                                            <span class="inline-flex px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                                {{ $priceList->category }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 hidden md:table-cell">
                                        <span class="text-slate-500">{{ $priceList->description ?: '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-baseline gap-1">
                                            <span class="text-xs font-medium text-slate-400">Rp</span>
                                            <span class="font-extrabold text-indigo-700 text-base">
                                                {{ number_format($priceList->base_price, 0, ',', '.') }}
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        @else
            {{-- Empty state --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-16 text-center">
                <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Daftar Harga</h3>
                <p class="text-slate-500 mb-6 max-w-md mx-auto">Informasi harga layanan belum tersedia. Silakan hubungi penjahit secara langsung.</p>
                <a href="{{ route('tailors.index') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:opacity-90 transition-opacity">
                    Cari Penjahit
                </a>
            </div>
        @endif

        {{-- ============================================================
             CTA SECTION — BROWSE TAILORS
             ============================================================ --}}
        @if($priceLists->isNotEmpty())
        <div class="mt-6 rounded-2xl overflow-hidden">
            <div class="relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 text-white p-8 sm:p-10">
                {{-- Decorative --}}
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white/5 blur-2xl"></div>
                    <svg class="absolute inset-0 w-full h-full opacity-[0.04]" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="cta-price-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#cta-price-grid)" />
                    </svg>
                </div>

                <div class="relative flex flex-col sm:flex-row items-start sm:items-center gap-6 justify-between">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-extrabold mb-2">Tertarik Memesan?</h3>
                        <p class="text-indigo-100 text-sm sm:text-base max-w-xl">
                            Jelajahi penjahit kami dan temukan yang terbaik sesuai kebutuhan Anda. Harga transparan, kualitas terjamin.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3 flex-shrink-0">
                        <a href="{{ route('tailors.index') }}"
                           class="inline-flex items-center gap-2 bg-white text-indigo-700 px-5 py-3 rounded-xl font-bold text-sm shadow-md hover:bg-indigo-50 transition-all hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                            </svg>
                            Browse Penjahit
                        </a>
                        @guest
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 bg-transparent text-white border-2 border-white/50 px-5 py-3 rounded-xl font-bold text-sm hover:bg-white/10 hover:border-white transition-all hover:-translate-y-0.5">
                            Daftar Gratis
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

{{-- Size comparison helper --}}
<section class="bg-white border-t border-slate-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h3 class="text-lg font-bold text-slate-700 mb-2">Panduan Biaya Tambahan Ukuran</h3>
            <p class="text-slate-500 text-sm">Estimasi total harga berdasarkan ukuran yang Anda pilih.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto">
            @php
                $sizes = [
                    ['size' => 'L', 'surcharge' => 5000, 'color' => 'indigo'],
                    ['size' => 'XL', 'surcharge' => 10000, 'color' => 'purple'],
                    ['size' => 'XXL', 'surcharge' => 15000, 'color' => 'violet'],
                    ['size' => 'Custom', 'surcharge' => 20000, 'color' => 'fuchsia'],
                ];
            @endphp
            @foreach($sizes as $s)
            <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center mx-auto mb-2">
                    <span class="font-black text-indigo-600 text-sm">{{ $s['size'] }}</span>
                </div>
                <p class="text-xs text-slate-400 mb-1">Tambahan</p>
                <p class="font-bold text-slate-700 text-sm">
                    + Rp {{ number_format($s['surcharge'], 0, ',', '.') }}
                </p>
            </div>
            @endforeach
        </div>
        <p class="text-center text-xs text-slate-400 mt-6">
            * Biaya tambahan berlaku untuk setiap item pesanan. Ukuran S dan M tidak dikenakan biaya tambahan.
        </p>
    </div>
</section>

@endsection
