@extends('layouts.app')

@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')
@section('page-subtitle', 'Kelola dan pantau semua pesanan jahit Anda')

{{-- ======================== SIDEBAR NAV ======================== --}}
@section('sidebar-nav')
    {{-- Dashboard --}}
    <a href="{{ route('customer.dashboard') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('customer.dashboard') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>

    {{-- Pesanan Saya --}}
    <a href="{{ route('customer.orders.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('customer.orders*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Pesanan Saya
    </a>

    {{-- Cari Penjahit --}}
    <a href="{{ route('tailors.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailors*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        Cari Penjahit
    </a>

    {{-- Daftar Harga --}}
    <a href="{{ route('price-lists.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('price-lists*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
        </svg>
        Daftar Harga
    </a>
@endsection

{{-- ======================== PAGE ACTIONS ======================== --}}
@section('page-actions')
    <a href="{{ route('tailors.index') }}"
       class="inline-flex items-center gap-2 gradient-brand text-white px-4 py-2 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Buat Pesanan Baru
    </a>
@endsection

{{-- ======================== CONTENT ======================== --}}
@section('content')
<div class="space-y-6">

    {{-- Summary Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @php
            $total      = $orders->total();
            $diproses   = $orders->getCollection()->where('status.value', 'diproses')->count();
            $selesai    = $orders->getCollection()->where('status.value', 'selesai')->count();
            $menunggu   = $orders->getCollection()->where('status.value', 'menunggu_konfirmasi')->count();
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Pesanan</p>
                <p class="text-xl font-bold text-slate-800">{{ $orders->total() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Menunggu</p>
                <p class="text-xl font-bold text-slate-800">{{ $menunggu }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Diproses</p>
                <p class="text-xl font-bold text-slate-800">{{ $diproses }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Selesai</p>
                <p class="text-xl font-bold text-slate-800">{{ $selesai }}</p>
            </div>
        </div>
    </div>

    {{-- Orders Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-800">Daftar Pesanan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Menampilkan {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan</p>
            </div>
        </div>

        @if($orders->isEmpty())
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
                <div class="w-20 h-20 rounded-2xl bg-indigo-50 flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Pesanan</h3>
                <p class="text-slate-500 text-sm max-w-sm mb-6">
                    Anda belum memiliki pesanan jahit. Temukan penjahit terbaik dan buat pesanan pertama Anda sekarang!
                </p>
                <a href="{{ route('tailors.index') }}"
                   class="inline-flex items-center gap-2 gradient-brand text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari Penjahit Sekarang
                </a>
            </div>
        @else
            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode Order</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Penjahit</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Ukuran</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Est. Harga</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-slate-50/60 transition-colors group">
                                {{-- Kode Order --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono font-semibold text-indigo-600 text-xs bg-indigo-50 px-2.5 py-1 rounded-lg">
                                        {{ $order->order_code }}
                                    </span>
                                </td>

                                {{-- Penjahit --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full gradient-brand flex items-center justify-center text-white text-xs font-bold shrink-0">
                                            {{ mb_substr($order->tailor->tailorProfile->shop_name ?? $order->tailor->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-800 text-xs leading-tight">
                                                {{ $order->tailor->tailorProfile->shop_name ?? '-' }}
                                            </p>
                                            <p class="text-slate-500 text-xs">{{ $order->tailor->name }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Item --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-medium text-slate-700">{{ $order->item_name }}</p>
                                    @if($order->category)
                                        <p class="text-slate-500 text-xs">{{ $order->category }}</p>
                                    @endif
                                </td>

                                {{-- Ukuran --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                        {{ $order->size }}
                                    </span>
                                    @if($order->quantity > 1)
                                        <span class="ml-1 text-xs text-slate-500">×{{ $order->quantity }}</span>
                                    @endif
                                </td>

                                {{-- Estimasi Harga --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($order->estimated_price)
                                        <span class="font-semibold text-slate-800">
                                            Rp {{ number_format($order->estimated_price, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs italic">Menunggu</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>

                                {{-- Tanggal --}}
                                <td class="px-6 py-4 whitespace-nowrap text-slate-500 text-xs">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('customer.orders.show', $order) }}"
                                       class="inline-flex items-center gap-1.5 text-indigo-600 hover:text-indigo-800 font-semibold text-xs bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
