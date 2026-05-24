@extends('layouts.customer')

@section('title', 'Dashboard – TailorTrack')

@section('content')

{{-- ================================================================
     HERO / WELCOME BANNER
     ================================================================ --}}
<section class="relative bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 rounded-2xl p-7 sm:p-10 text-white overflow-hidden shadow-xl shadow-indigo-200 mb-8">

    {{-- Decorative blobs --}}
    <div class="absolute -right-12 -top-12 w-56 h-56 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute right-1/4 -bottom-12 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute left-1/2 top-0 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl pointer-events-none"></div>
    {{-- Grid pattern --}}
    <svg class="absolute inset-0 w-full h-full opacity-[0.04] pointer-events-none" xmlns="http://www.w3.org/2000/svg">
        <defs><pattern id="dash-grid" width="32" height="32" patternUnits="userSpaceOnUse">
            <path d="M 32 0 L 0 0 0 32" fill="none" stroke="white" stroke-width="1"/>
        </pattern></defs>
        <rect width="100%" height="100%" fill="url(#dash-grid)"/>
    </svg>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur-sm text-white text-xs px-3 py-1.5 rounded-full font-semibold border border-white/20 mb-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                </span>
                Halo kembali 👋
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-2">
                Selamat Datang,<br>
                <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                    {{ auth()->user()->name }}!
                </span>
            </h1>
            <p class="text-indigo-100 text-sm sm:text-base leading-relaxed max-w-lg">
                Temukan penjahit profesional, diskusikan desain impian Anda, dan pantau progress pesanan — semua dalam satu tempat.
            </p>
        </div>

        {{-- CTA Buttons --}}
        <div class="flex flex-wrap gap-3 shrink-0">
            <a href="{{ route('tailors.index') }}"
               class="inline-flex items-center gap-2 bg-white text-indigo-700 font-bold px-6 py-3 rounded-xl text-sm shadow-lg shadow-indigo-900/20 hover:bg-indigo-50 hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Pesanan Baru
            </a>
            <a href="{{ route('customer.orders.index') }}"
               class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white font-semibold px-5 py-3 rounded-xl text-sm border border-white/25 backdrop-blur-sm transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
                Pesanan Saya
            </a>
        </div>
    </div>
</section>

{{-- ================================================================
     STAT CARDS
     ================================================================ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    {{-- Total Pesanan --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                </svg>
            </div>
            <span class="text-[11px] font-semibold text-indigo-400 bg-indigo-50 px-2 py-0.5 rounded-full">Total</span>
        </div>
        <p class="text-3xl font-extrabold text-slate-800">{{ $stats['total'] ?? 0 }}</p>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Semua Pesanan</p>
    </div>

    {{-- Menunggu Pembayaran --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                </svg>
            </div>
            @if(($stats['menunggu_pembayaran'] ?? 0) > 0)
                <span class="text-[11px] font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full animate-pulse">Perlu Aksi</span>
            @endif
        </div>
        <p class="text-3xl font-extrabold {{ ($stats['menunggu_pembayaran'] ?? 0) > 0 ? 'text-orange-500' : 'text-slate-800' }}">
            {{ $stats['menunggu_pembayaran'] ?? 0 }}
        </p>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Menunggu Bayar</p>
    </div>

    {{-- Diproses --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                </svg>
            </div>
            <span class="text-[11px] font-semibold text-blue-400 bg-blue-50 px-2 py-0.5 rounded-full">Aktif</span>
        </div>
        <p class="text-3xl font-extrabold text-blue-600">{{ $stats['diproses'] ?? 0 }}</p>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Sedang Diproses</p>
    </div>

    {{-- Selesai --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">✓ Done</span>
        </div>
        <p class="text-3xl font-extrabold text-emerald-600">{{ $stats['selesai'] ?? 0 }}</p>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Pesanan Selesai</p>
    </div>

</div>

{{-- ================================================================
     ALERT: Pembayaran Pending
     ================================================================ --}}
@if(isset($stats['menunggu_pembayaran']) && $stats['menunggu_pembayaran'] > 0)
<div class="bg-orange-50 border border-orange-200 rounded-2xl p-4 mb-8 flex items-center gap-4">
    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
        </svg>
    </div>
    <div class="flex-1">
        <p class="text-sm font-bold text-orange-800">
            {{ $stats['menunggu_pembayaran'] }} pesanan menunggu pembayaran
        </p>
        <p class="text-xs text-orange-600 mt-0.5">Segera selesaikan pembayaran agar penjahit dapat mulai mengerjakan pesanan Anda.</p>
    </div>
    <a href="{{ route('customer.orders.index') }}"
       class="shrink-0 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-sm">
        Bayar Sekarang
    </a>
</div>
@endif

{{-- ================================================================
     MAIN GRID: Recent Orders + Tailors + Quick Actions
     ================================================================ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ============================================================
         LEFT: Recent Orders (2/3 width)
         ============================================================ --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Recent Orders Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-50">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Pesanan Terbaru</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pantau status pesanan jahit Anda</p>
                </div>
                <a href="{{ route('customer.orders.index') }}"
                   class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @forelse($recentOrders as $order)
            <div class="px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50/60 transition-colors group">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        {{-- Status indicator dot --}}
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0 mt-0.5 group-hover:bg-indigo-100 transition-colors">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <span class="font-mono text-[11px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-semibold">
                                    {{ $order->order_code }}
                                </span>
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $order->status->badgeColor() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </div>
                            <p class="font-semibold text-slate-800 text-sm truncate">{{ $order->item_name }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ $order->tailor->tailorProfile->shop_name ?? $order->tailor->name ?? '-' }}
                                <span class="text-slate-300">·</span>
                                {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        @if($order->total_price)
                            <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        @elseif($order->estimated_price)
                            <p class="text-sm text-slate-500 font-semibold">~Rp {{ number_format($order->estimated_price, 0, ',', '.') }}</p>
                        @else
                            <p class="text-xs text-slate-300 italic">Estimasi belum ada</p>
                        @endif
                        <a href="{{ route('customer.orders.show', $order) }}"
                           class="text-xs text-indigo-600 hover:text-indigo-700 font-semibold mt-1 inline-flex items-center gap-0.5 group-hover:gap-1 transition-all">
                            Detail
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16 px-6">
                <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-700 text-lg mb-1">Belum ada pesanan</h3>
                <p class="text-slate-400 text-sm mb-6 max-w-xs mx-auto">Mulai pesanan pertama Anda sekarang dengan memilih penjahit yang sesuai kebutuhan!</p>
                <a href="{{ route('tailors.index') }}"
                   class="inline-flex items-center gap-2 gradient-brand text-white px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-opacity shadow-md shadow-indigo-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Penjahit Sekarang
                </a>
            </div>
            @endforelse
        </div>

        {{-- Recommended Tailors --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Rekomendasi Penjahit</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Penjahit terverifikasi siap melayani Anda</p>
                </div>
                <a href="{{ route('tailors.index') }}"
                   class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
                    Lihat Semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($featuredTailors as $tailor)
                @php
                    $profile = $tailor->tailorProfile;
                    $shopName = $profile->shop_name ?? $tailor->name;
                    $words = explode(' ', trim($shopName));
                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                    $colors = [
                        ['from-indigo-400', 'to-purple-500'],
                        ['from-violet-400', 'to-fuchsia-500'],
                        ['from-blue-400', 'to-indigo-500'],
                        ['from-purple-400', 'to-pink-500'],
                    ];
                    $color = $colors[$loop->index % count($colors)];
                @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 card-hover flex flex-col justify-between">
                    <div class="flex items-start gap-4">
                        {{-- Avatar --}}
                        <div class="relative shrink-0">
                            @if($profile && $profile->photo)
                                <img src="{{ Storage::url($profile->photo) }}" alt="{{ $shopName }}"
                                     class="w-14 h-14 rounded-xl object-cover ring-2 ring-indigo-100">
                            @else
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br {{ $color[0] }} {{ $color[1] }} flex items-center justify-center text-white font-bold text-lg ring-2 ring-indigo-100">
                                    {{ $initials }}
                                </div>
                            @endif
                            @if($profile && $profile->is_available)
                                <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 border-2 border-white rounded-full"></span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5 flex-wrap mb-0.5">
                                <h3 class="font-bold text-slate-800 text-sm truncate max-w-[140px]">{{ $shopName }}</h3>
                                @if($profile && $profile->is_verified)
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            @if($profile && $profile->specialization)
                                <span class="inline-flex items-center gap-1 text-[11px] text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full font-semibold">
                                    {{ $profile->specialization }}
                                </span>
                            @endif
                            <div class="flex items-center gap-3 mt-2 text-[11px] text-slate-400">
                                @if($profile && $profile->experience_years)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $profile->experience_years }} thn
                                    </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/></svg>
                                    {{ $tailor->portfolios_count ?? $tailor->portfolios->count() }} karya
                                </span>
                                @if($profile && $profile->is_available)
                                    <span class="text-emerald-500 font-semibold">• Tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('tailors.show', $tailor) }}"
                       class="mt-4 w-full text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs py-2.5 rounded-xl transition-colors">
                        Lihat Profil & Pesan
                    </a>
                </div>
                @empty
                <div class="sm:col-span-2 text-center py-10 text-slate-400">
                    <p class="text-sm">Belum ada penjahit tersedia</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- ============================================================
         RIGHT PANEL (1/3 width)
         ============================================================ --}}
    <div class="space-y-5">

        {{-- Profile Card --}}
        <div class="gradient-brand rounded-2xl p-5 text-white shadow-lg shadow-indigo-200 relative overflow-hidden">
            <div class="absolute -top-8 -right-8 w-28 h-28 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white text-lg font-extrabold shadow-inner">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-base leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-indigo-200 text-xs">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="relative z-10 grid grid-cols-2 gap-2">
                <div class="bg-white/10 rounded-xl p-3 text-center">
                    <p class="text-xl font-extrabold">{{ $stats['total'] ?? 0 }}</p>
                    <p class="text-indigo-200 text-[11px]">Total Pesanan</p>
                </div>
                <div class="bg-white/10 rounded-xl p-3 text-center">
                    <p class="text-xl font-extrabold">{{ $stats['selesai'] ?? 0 }}</p>
                    <p class="text-indigo-200 text-[11px]">Selesai</p>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-slate-800 text-sm mb-3">Aksi Cepat</h3>
            <div class="space-y-2">
                <a href="{{ route('tailors.index') }}"
                   class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 transition-colors group">
                    <div class="w-8 h-8 gradient-brand rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-indigo-700 leading-tight">Buat Pesanan Baru</p>
                        <p class="text-[11px] text-indigo-400">Temukan penjahit terbaik</p>
                    </div>
                    <svg class="w-4 h-4 text-indigo-300 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('customer.orders.index') }}"
                   class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors group">
                    <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-700 leading-tight">Semua Pesanan</p>
                        <p class="text-[11px] text-slate-400">Lacak status pesanan</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('price-lists.index') }}"
                   class="flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors group">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-700 leading-tight">Lihat Daftar Harga</p>
                        <p class="text-[11px] text-slate-400">Estimasi biaya jahit</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-300 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Cara Memesan --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-bold text-slate-800 text-sm mb-4">Cara Memesan</h3>
            <div class="space-y-4 relative">
                {{-- Vertical line --}}
                <div class="absolute left-[15px] top-7 bottom-7 w-px bg-indigo-100"></div>
                <div class="flex gap-3 relative z-10">
                    <div class="w-8 h-8 gradient-brand rounded-full flex items-center justify-center text-white text-xs font-extrabold shrink-0 shadow-sm shadow-indigo-200">1</div>
                    <div class="pt-1">
                        <p class="text-sm font-bold text-slate-700">Pilih Penjahit</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Browse dan pilih penjahit sesuai spesialisasi & budget Anda</p>
                    </div>
                </div>
                <div class="flex gap-3 relative z-10">
                    <div class="w-8 h-8 gradient-brand rounded-full flex items-center justify-center text-white text-xs font-extrabold shrink-0 shadow-sm shadow-indigo-200">2</div>
                    <div class="pt-1">
                        <p class="text-sm font-bold text-slate-700">Isi Form Pesanan</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Pilih jenis, ukuran, dan upload foto referensi pakaian</p>
                    </div>
                </div>
                <div class="flex gap-3 relative z-10">
                    <div class="w-8 h-8 gradient-brand rounded-full flex items-center justify-center text-white text-xs font-extrabold shrink-0 shadow-sm shadow-indigo-200">3</div>
                    <div class="pt-1">
                        <p class="text-sm font-bold text-slate-700">Bayar & Pantau</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Upload bukti pembayaran dan pantau progress secara real-time</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
