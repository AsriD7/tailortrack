@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Pantau seluruh aktivitas platform TailorTrack')

{{-- =====================================================================
     SIDEBAR NAV
     ===================================================================== --}}
@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
        {{-- Home icon --}}
        <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        Dashboard
    </a>

    <a href="{{ route('admin.tailors.index') }}"
       class="nav-link {{ request()->routeIs('admin.tailors*') ? 'active' : '' }}">
        {{-- Scissors icon --}}
        <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M7.848 8.25l1.536.887M7.848 8.25a3 3 0 11-5.196-3 3 3 0 015.196 3zm1.536.887a2.165 2.165 0 011.083 1.839c.005.351.054.695.14 1.024M9.384 9.137l2.077 1.199M7.848 15.75l1.536-.887m-1.536.887a3 3 0 11-5.196 3 3 3 0 015.196-3zm1.536-.887a2.165 2.165 0 001.083-1.838c.005-.352.054-.695.14-1.025m-1.223 2.863l2.077-1.199m0-3.328a4.323 4.323 0 012.068-1.379l5.325-1.628a4.5 4.5 0 012.48-.044l.803.215-7.794 4.5m-2.882-1.664A4.33 4.33 0 0010.607 12m3.736 0l7.794 4.499-.802.215a4.5 4.5 0 01-2.48-.044l-5.326-1.628a4.324 4.324 0 01-2.068-1.379M14.343 12l-2.882 1.664" />
        </svg>
        Penjahit
    </a>

    <a href="{{ route('admin.users.index', ['role' => 'customer']) }}"
       class="nav-link {{ request()->routeIs('admin.users*') && request()->get('role') === 'customer' ? 'active' : '' }}">
        {{-- User icon --}}
        <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
        </svg>
        Customer
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="nav-link {{ request()->routeIs('admin.users*') && !request()->get('role') ? 'active' : '' }}">
        {{-- Users group icon --}}
        <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
        </svg>
        Semua User
    </a>

    <a href="{{ route('admin.price-lists.index') }}"
       class="nav-link {{ request()->routeIs('admin.price-lists*') ? 'active' : '' }}">
        {{-- Tag icon --}}
        <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
        </svg>
        Daftar Harga
    </a>

    <a href="{{ route('admin.orders.index') }}"
       class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        {{-- Clipboard list icon --}}
        <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Semua Pesanan
    </a>

    <a href="{{ route('admin.payments.index') }}"
       class="nav-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
        {{-- Credit card icon --}}
        <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
        </svg>
        Pembayaran
    </a>

    <a href="{{ route('admin.reviews.index') }}"
       class="nav-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
        <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557L3.04 10.385a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345l2.125-5.111z" />
        </svg>
        Review
    </a>
@endsection

{{-- =====================================================================
     PAGE ACTIONS
     ===================================================================== --}}
@section('page-actions')
    <a href="{{ route('admin.orders.index') }}"
       class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-slate-200 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        Semua Pesanan
    </a>
    <a href="{{ route('admin.tailors.index') }}"
       class="brand-gradient text-white px-4 py-2 rounded-lg font-semibold text-sm hover:opacity-90 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Kelola Penjahit
    </a>
@endsection

{{-- =====================================================================
     MAIN CONTENT
     ===================================================================== --}}
@section('content')

    {{-- ------------------------------------------------------------------ --}}
    {{-- STAT CARDS  (5-col grid)                                            --}}
    {{-- ------------------------------------------------------------------ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

        {{-- Total Customer --}}
        <div class="bg-white rounded-2xl p-6 shadow-soft border border-tailor-purple/10">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-500 text-xs font-medium leading-tight">Total Customer</span>
                <div class="bg-sky-50 p-2 rounded-lg shrink-0">
                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ number_format($stats['total_customer'] ?? 0) }}</p>
            <p class="text-slate-400 text-xs mt-1">Pengguna terdaftar</p>
        </div>

        {{-- Total Penjahit --}}
        <div class="bg-white rounded-2xl p-6 shadow-soft border border-tailor-purple/10">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-500 text-xs font-medium leading-tight">Total Penjahit</span>
                <div class="bg-violet-50 p-2 rounded-lg shrink-0">
                    <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ number_format($stats['total_tailor'] ?? 0) }}</p>
            <p class="text-slate-400 text-xs mt-1">Penjahit aktif</p>
        </div>

        {{-- Total Pesanan --}}
        <div class="brand-gradient text-white rounded-2xl p-6 shadow-lg shadow-tailor-purple/20 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="absolute -right-2 -bottom-6 w-14 h-14 bg-white/10 rounded-full"></div>
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
                <p class="text-3xl font-bold">{{ number_format($stats['total_order'] ?? 0) }}</p>
                <p class="text-white/70 text-xs mt-1">Semua transaksi</p>
            </div>
        </div>

        {{-- Pembayaran Pending --}}
        <div class="bg-white rounded-2xl p-6 shadow-soft border border-tailor-purple/10">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-500 text-xs font-medium leading-tight">Pembayaran Pending</span>
                <div class="bg-orange-50 p-2 rounded-lg shrink-0">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-orange-600">{{ number_format($stats['pending_payment'] ?? 0) }}</p>
            <p class="text-slate-400 text-xs mt-1">Menunggu verifikasi</p>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white rounded-2xl p-6 shadow-soft border border-tailor-purple/10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-3xl opacity-50"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-slate-500 text-xs font-medium leading-tight">Total Revenue</span>
                    <div class="bg-emerald-50 p-2 rounded-lg shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-bold text-emerald-600 leading-tight">
                    Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-slate-400 text-xs mt-1">Platform revenue</p>
            </div>
        </div>

    </div>

    {{-- ------------------------------------------------------------------ --}}
    {{-- RECENT ORDERS TABLE                                                  --}}
    {{-- ------------------------------------------------------------------ --}}
    <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">

        {{-- Card header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h2 class="text-base font-semibold text-slate-800">Pesanan Terbaru</h2>
                <p class="text-slate-400 text-xs mt-0.5">Transaksi terkini di seluruh platform</p>
            </div>
            <a href="{{ route('admin.orders.index') }}"
               class="text-tailor-purple hover:text-tailor-purple text-sm font-semibold flex items-center gap-1 transition">
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
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-slate-700 font-semibold text-base mb-1">Belum Ada Transaksi</h3>
                <p class="text-slate-400 text-sm max-w-xs">
                    Pesanan dari seluruh platform akan muncul di sini secara real-time.
                </p>
            </div>
        @else
            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                            <th class="px-6 py-3.5 text-left">Kode Pesanan</th>
                            <th class="px-6 py-3.5 text-left">Customer</th>
                            <th class="px-6 py-3.5 text-left">Toko Penjahit</th>
                            <th class="px-6 py-3.5 text-left">Status</th>
                            <th class="px-6 py-3.5 text-right">Total Harga</th>
                            <th class="px-6 py-3.5 text-left">Tanggal</th>
                            <th class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50/60 transition-colors">

                                {{-- Order code --}}
                                <td class="px-6 py-4">
                                    <span class="font-mono font-semibold text-tailor-purple text-xs bg-tailor-soft px-2.5 py-1 rounded-md">
                                        {{ $order->order_code }}
                                    </span>
                                </td>

                                {{-- Customer --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 text-xs font-bold shrink-0">
                                            {{ mb_substr($order->customer->name ?? 'C', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800 leading-tight">
                                                {{ $order->customer->name ?? '-' }}
                                            </p>
                                            <p class="text-slate-400 text-xs leading-tight">
                                                {{ $order->customer->email ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Tailor shop name --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full brand-gradient flex items-center justify-center text-white text-xs font-bold shrink-0">
                                            {{ mb_substr($order->tailor->shop_name ?? 'T', 0, 1) }}
                                        </div>
                                        <span class="font-medium text-slate-700">
                                            {{ $order->tailor->shop_name ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Status badge --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>

                                {{-- Total price --}}
                                <td class="px-6 py-4 text-right font-semibold text-slate-800 whitespace-nowrap">
                                    @if($order->total_price)
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    @else
                                        <span class="text-slate-400 font-normal text-xs">Belum ada</span>
                                    @endif
                                </td>

                                {{-- Created at --}}
                                <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>

                                {{-- Action --}}
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                       class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-tailor-soft text-slate-600 hover:text-tailor-purple font-semibold text-xs px-3 py-1.5 rounded-lg transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
@endsection
