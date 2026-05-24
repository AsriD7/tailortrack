@extends('layouts.app')

@section('title', 'Dashboard Penjahit')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Pantau bisnis jahit Anda hari ini')

{{-- =====================================================================
     SIDEBAR NAV
     ===================================================================== --}}
@section('sidebar-nav')
    <a href="{{ route('tailor.dashboard') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailor.dashboard*') ? 'active bg-white/15 text-white' : '' }}">
        {{-- Home icon --}}
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        Dashboard
    </a>

    <a href="{{ route('tailor.profile.edit') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailor.profile*') ? 'active bg-white/15 text-white' : '' }}">
        {{-- Store icon --}}
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
        </svg>
        Profil Toko
    </a>

    <a href="{{ route('tailor.portfolios.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailor.portfolios*') ? 'active bg-white/15 text-white' : '' }}">
        {{-- Photo gallery icon --}}
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
        </svg>
        Portfolio
    </a>

    <a href="{{ route('tailor.orders.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailor.orders*') ? 'active bg-white/15 text-white' : '' }}">
        {{-- Inbox icon --}}
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
        </svg>
        Pesanan Masuk
        @if(($stats['menunggu_konfirmasi'] ?? 0) > 0)
            <span class="ml-auto bg-yellow-400 text-yellow-900 text-xs font-bold px-1.5 py-0.5 rounded-full">
                {{ $stats['menunggu_konfirmasi'] }}
            </span>
        @endif
    </a>
@endsection

{{-- =====================================================================
     PAGE ACTIONS
     ===================================================================== --}}
@section('page-actions')
    <a href="{{ route('tailor.orders.index') }}"
       class="gradient-brand text-white px-4 py-2 rounded-lg font-semibold text-sm hover:opacity-90 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
        </svg>
        Kelola Pesanan
    </a>
@endsection

{{-- =====================================================================
     MAIN CONTENT
     ===================================================================== --}}
@section('content')

    {{-- Hanya tampil alert jika profil belum lengkap ATAU belum terverifikasi --}}
    @if(!$tailorProfile || !$tailorProfile->shop_name)
        {{-- Profil belum diisi sama sekali --}}
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-4">
            <div class="bg-amber-100 text-amber-600 p-2 rounded-lg shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-amber-800 text-sm">Profil Toko Belum Lengkap</h4>
                <p class="text-amber-700 text-xs mt-0.5">
                    Lengkapi profil toko Anda agar pelanggan dapat menemukan dan memesan layanan Anda.
                </p>
                <a href="{{ route('tailor.profile.edit') }}"
                   class="mt-3 inline-flex items-center gap-1.5 bg-amber-600 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-amber-700 transition">
                    Lengkapi Profil Sekarang
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
        </div>
    @elseif($tailorProfile && $tailorProfile->shop_name && !$tailorProfile->is_verified)
        {{-- Profil sudah diisi tapi belum diverifikasi admin --}}
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-2xl p-5 flex items-start gap-4">
            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-blue-800 text-sm">Menunggu Verifikasi Admin</h4>
                <p class="text-blue-700 text-xs mt-0.5">
                    Profil toko Anda sedang dalam proses verifikasi oleh admin. Anda akan mendapat notifikasi setelah diverifikasi.
                </p>
            </div>
        </div>
    @endif


    {{-- ------------------------------------------------------------------ --}}
    {{-- STAT CARDS                                                           --}}
    {{-- ------------------------------------------------------------------ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

        {{-- Total Pesanan --}}
        <div class="gradient-brand text-white rounded-2xl p-6 shadow-lg shadow-indigo-200/50 relative overflow-hidden xl:col-span-1">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="absolute -right-2 -bottom-6 w-16 h-16 bg-white/10 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-white/80 text-xs font-medium leading-tight">Total Pesanan</span>
                    <div class="bg-white/20 p-2 rounded-lg shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold">{{ $stats['total'] ?? 0 }}</p>
                <p class="text-white/70 text-xs mt-1">Semua pesanan</p>
            </div>
        </div>

        {{-- Menunggu Konfirmasi --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-500 text-xs font-medium leading-tight">Menunggu Konfirmasi</span>
                <div class="bg-yellow-50 p-2 rounded-lg shrink-0">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ $stats['menunggu_konfirmasi'] ?? 0 }}</p>
            <p class="text-slate-400 text-xs mt-1">Perlu dikonfirmasi</p>
        </div>

        {{-- Diproses --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-500 text-xs font-medium leading-tight">Sedang Diproses</span>
                <div class="bg-indigo-50 p-2 rounded-lg shrink-0">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ $stats['diproses'] ?? 0 }}</p>
            <p class="text-slate-400 text-xs mt-1">Sedang dikerjakan</p>
        </div>

        {{-- Selesai --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-500 text-xs font-medium leading-tight">Selesai</span>
                <div class="bg-emerald-50 p-2 rounded-lg shrink-0">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ $stats['selesai'] ?? 0 }}</p>
            <p class="text-slate-400 text-xs mt-1">Telah selesai</p>
        </div>

        {{-- Total Pendapatan --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-3xl opacity-60"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-slate-500 text-xs font-medium leading-tight">Total Pendapatan</span>
                    <div class="bg-emerald-50 p-2 rounded-lg shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-emerald-600 leading-tight">
                    Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-slate-400 text-xs mt-1">Dari pesanan selesai</p>
            </div>
        </div>

    </div>

    {{-- ------------------------------------------------------------------ --}}
    {{-- RECENT ORDERS TABLE                                                  --}}
    {{-- ------------------------------------------------------------------ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        {{-- Card header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h2 class="text-base font-semibold text-slate-800">Pesanan Terbaru</h2>
                <p class="text-slate-400 text-xs mt-0.5">Pesanan masuk yang terkini dari pelanggan</p>
            </div>
            <a href="{{ route('tailor.orders.index') }}"
               class="text-indigo-600 hover:text-indigo-700 text-sm font-semibold flex items-center gap-1 transition">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>

        @if($recentOrders->isEmpty())
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
                    </svg>
                </div>
                <h3 class="text-slate-700 font-semibold text-base mb-1">Belum Ada Pesanan Masuk</h3>
                <p class="text-slate-400 text-sm max-w-xs">
                    Pesanan dari pelanggan akan muncul di sini. Pastikan profil toko Anda lengkap dan menarik!
                </p>
            </div>
        @else
            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Kode Pesanan</th>
                            <th class="px-6 py-3.5 text-left">Pelanggan</th>
                            <th class="px-6 py-3.5 text-left">Item</th>
                            <th class="px-6 py-3.5 text-left">Status</th>
                            <th class="px-6 py-3.5 text-right">Harga</th>
                            <th class="px-6 py-3.5 text-left">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50/60 transition-colors">

                                {{-- Order code --}}
                                <td class="px-6 py-4">
                                    <span class="font-mono font-semibold text-indigo-600 text-xs bg-indigo-50 px-2.5 py-1 rounded-md">
                                        {{ $order->order_code }}
                                    </span>
                                </td>

                                {{-- Customer name --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-xs font-bold shrink-0">
                                            {{ mb_substr($order->customer->name ?? 'C', 0, 1) }}
                                        </div>
                                        <span class="font-medium text-slate-800">
                                            {{ $order->customer->name ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Item name --}}
                                <td class="px-6 py-4 text-slate-600 max-w-[180px] truncate">
                                    {{ $order->item_name }}
                                </td>

                                {{-- Status badge --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>

                                {{-- Price (prefer total_price, fallback estimated_price) --}}
                                <td class="px-6 py-4 text-right font-semibold text-slate-800 whitespace-nowrap">
                                    @if($order->total_price)
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    @elseif($order->estimated_price)
                                        <span class="text-slate-500 font-normal">~</span>
                                        Rp {{ number_format($order->estimated_price, 0, ',', '.') }}
                                    @else
                                        <span class="text-slate-400 font-normal text-xs">Belum ditetapkan</span>
                                    @endif
                                </td>

                                {{-- Created at --}}
                                <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
@endsection
