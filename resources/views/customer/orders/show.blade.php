@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_code)
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', 'Kode: ' . $order->order_code)

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
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium active bg-white/15 text-white">
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
    <a href="{{ route('customer.orders.index') }}"
       class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar
    </a>
@endsection

{{-- ======================== CONTENT ======================== --}}
@section('content')
<div class="space-y-6">

    {{-- ── Order Header Banner ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-3 mb-1">
                    <h1 class="text-xl font-bold text-slate-800 font-mono">{{ $order->order_code }}</h1>
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">
                        {{ $order->status->label() }}
                    </span>
                </div>
                <p class="text-sm text-slate-500">
                    Dibuat pada {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB
                </p>
            </div>
            {{-- Progress steps --}}
            <div class="flex items-center gap-1 shrink-0 overflow-x-auto pb-1">
                @php
                    $steps = [
                        ['key' => 'menunggu_konfirmasi', 'label' => 'Konfirmasi'],
                        ['key' => 'menunggu_pembayaran', 'label' => 'Pembayaran'],
                        ['key' => 'dibayar',             'label' => 'Dibayar'],
                        ['key' => 'diproses',            'label' => 'Diproses'],
                        ['key' => 'selesai',             'label' => 'Selesai'],
                    ];
                    $statusValues = \App\Enums\OrderStatus::cases();
                    $currentIndex = collect($steps)->search(fn($s) => $s['key'] === $order->status->value);
                    $isCancelled  = $order->status === \App\Enums\OrderStatus::Dibatalkan;
                @endphp

                @if($isCancelled)
                    <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Pesanan Dibatalkan
                    </span>
                @else
                    @foreach($steps as $i => $step)
                        <div class="flex items-center">
                            <div class="flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shrink-0
                                    {{ $i < $currentIndex ? 'bg-indigo-600 text-white' : ($i === $currentIndex ? 'gradient-brand text-white ring-2 ring-indigo-200' : 'bg-slate-100 text-slate-400') }}">
                                    @if($i < $currentIndex)
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </div>
                                <span class="text-xs mt-1 whitespace-nowrap {{ $i === $currentIndex ? 'text-indigo-600 font-semibold' : 'text-slate-400' }}">
                                    {{ $step['label'] }}
                                </span>
                            </div>
                            @if(!$loop->last)
                                <div class="w-6 h-0.5 mb-4 mx-1 {{ $i < $currentIndex ? 'bg-indigo-400' : 'bg-slate-200' }}"></div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- ── Main 2-column Layout ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- ===== LEFT COLUMN (3/5) ===== --}}
        <div class="lg:col-span-3 space-y-6">

            {{-- Order Info Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                    </svg>
                    Detail Pesanan
                </h2>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <dt class="text-xs font-medium text-slate-400 mb-0.5">Nama Item</dt>
                        <dd class="text-sm font-semibold text-slate-800">{{ $order->item_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-400 mb-0.5">Kategori</dt>
                        <dd class="text-sm font-semibold text-slate-800">{{ $order->category ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-400 mb-0.5">Ukuran</dt>
                        <dd>
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                {{ $order->size }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-400 mb-0.5">Jumlah</dt>
                        <dd class="text-sm font-semibold text-slate-800">{{ $order->quantity }} pcs</dd>
                    </div>
                    @if($order->deadline)
                        <div>
                            <dt class="text-xs font-medium text-slate-400 mb-0.5">Deadline</dt>
                            <dd class="text-sm font-semibold text-slate-800 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($order->deadline)->translatedFormat('d F Y') }}
                            </dd>
                        </div>
                    @endif
                    @if($order->description)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium text-slate-400 mb-0.5">Deskripsi</dt>
                            <dd class="text-sm text-slate-700 leading-relaxed bg-slate-50 rounded-lg p-3">{{ $order->description }}</dd>
                        </div>
                    @endif
                    @if($order->note)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium text-slate-400 mb-0.5">Catatan</dt>
                            <dd class="text-sm text-slate-700 leading-relaxed bg-amber-50 border border-amber-100 rounded-lg p-3">{{ $order->note }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Penjahit Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informasi Penjahit
                </h2>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl gradient-brand flex items-center justify-center text-white font-bold text-lg shrink-0">
                        {{ mb_substr($order->tailor->tailorProfile->shop_name ?? $order->tailor->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-slate-800">{{ $order->tailor->tailorProfile->shop_name ?? '-' }}</p>
                        <p class="text-sm text-slate-500">{{ $order->tailor->name }}</p>
                        @if($order->tailor->tailorProfile->phone ?? false)
                            <a href="tel:{{ $order->tailor->tailorProfile->phone }}"
                               class="inline-flex items-center gap-1.5 text-indigo-600 text-xs font-medium mt-1 hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $order->tailor->tailorProfile->phone }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Price Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Harga
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Estimasi Harga</span>
                        <span class="font-semibold text-slate-800">
                            @if($order->estimated_price)
                                Rp {{ number_format($order->estimated_price, 0, ',', '.') }}
                            @else
                                <span class="text-slate-400 italic text-xs">Menunggu konfirmasi penjahit</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-sm pt-3 border-t border-slate-100">
                        <span class="font-semibold text-slate-700">Total Harga Final</span>
                        <span class="text-lg font-bold {{ $order->total_price ? 'text-indigo-600' : 'text-slate-400' }}">
                            @if($order->total_price)
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            @else
                                <span class="text-xs italic font-normal">Menunggu konfirmasi</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Reference Images --}}
            @if($order->images && count($order->images) > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Foto Referensi
                        <span class="ml-auto text-xs font-normal text-slate-400 normal-case">{{ count($order->images) }} foto</span>
                    </h2>
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($order->images as $image)
                            <a href="{{ Storage::url($image) }}" target="_blank" rel="noopener"
                               class="group block aspect-square rounded-xl overflow-hidden border border-slate-200 hover:border-indigo-400 transition-all hover:shadow-md">
                                <img src="{{ Storage::url($image) }}"
                                     alt="Foto Referensi"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Cancellation Info --}}
            @if($order->status === \App\Enums\OrderStatus::Dibatalkan)
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <h2 class="text-sm font-semibold text-red-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Pembatalan
                    </h2>
                    <dl class="space-y-3">
                        @if($order->cancelled_at)
                            <div>
                                <dt class="text-xs font-medium text-red-500 mb-0.5">Dibatalkan Pada</dt>
                                <dd class="text-sm font-semibold text-red-800">
                                    {{ \Carbon\Carbon::parse($order->cancelled_at)->translatedFormat('d F Y, H:i') }} WIB
                                </dd>
                            </div>
                        @endif
                        @if($order->cancel_reason)
                            <div>
                                <dt class="text-xs font-medium text-red-500 mb-0.5">Alasan Pembatalan</dt>
                                <dd class="text-sm text-red-800 bg-red-100/60 rounded-lg p-3 leading-relaxed">
                                    {{ $order->cancel_reason }}
                                </dd>
                            </div>
                        @endif
                        @if($order->cancelledBy)
                            <div>
                                <dt class="text-xs font-medium text-red-500 mb-0.5">Dibatalkan Oleh</dt>
                                <dd class="text-sm font-semibold text-red-800">{{ $order->cancelledBy->name }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif

        </div>{{-- end left --}}

        {{-- ===== RIGHT COLUMN (2/5) ===== --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Tracking / History Timeline --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Riwayat Pesanan
                </h2>

                @if($order->trackingHistories && $order->trackingHistories->count() > 0)
                    <div class="relative">
                        {{-- Vertical line --}}
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-100"></div>

                        <div class="space-y-6">
                            @foreach($order->trackingHistories->sortByDesc('created_at') as $history)
                                <div class="flex gap-4 relative">
                                    {{-- Dot --}}
                                    <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center z-10
                                        {{ $loop->first ? 'gradient-brand shadow-sm' : 'bg-slate-100' }}">
                                        @if($loop->first)
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @else
                                            <div class="w-2.5 h-2.5 rounded-full bg-slate-300"></div>
                                        @endif
                                    </div>
                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0 pb-2">
                                        @php $historyStatus = \App\Enums\OrderStatus::tryFrom($history->status); @endphp
                                        @if($historyStatus)
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold mb-1 {{ $historyStatus->badgeColor() }}">
                                                {{ $historyStatus->label() }}
                                            </span>
                                        @elseif($history->status)
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold mb-1 bg-slate-100 text-slate-600">
                                                {{ $history->status }}
                                            </span>
                                        @endif
                                        @if($history->description)
                                            <p class="text-sm text-slate-700 leading-relaxed">{{ $history->description }}</p>
                                        @endif
                                        <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                            <span class="text-xs text-slate-400">
                                                {{ $history->created_at->translatedFormat('d M Y, H:i') }}
                                            </span>
                                            @if($history->updatedByUser ?? false)
                                                <span class="text-xs text-slate-300">&bull;</span>
                                                <span class="text-xs text-slate-500 font-medium">
                                                    {{ $history->updatedByUser->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-slate-400">Belum ada riwayat aktivitas</p>
                    </div>
                @endif
            </div>

            {{-- Payment Upload Form --}}
            @if($order->status === \App\Enums\OrderStatus::MenungguPembayaran)
                <div class="bg-white rounded-2xl shadow-sm border border-orange-200 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Upload Bukti Pembayaran</h2>
                            <p class="text-xs text-slate-500">Upload bukti transfer untuk konfirmasi</p>
                        </div>
                    </div>

                    @if($order->total_price)
                        <div class="bg-orange-50 border border-orange-100 rounded-xl p-3 mb-4">
                            <p class="text-xs text-orange-700">Jumlah yang harus dibayar:</p>
                            <p class="text-lg font-bold text-orange-800 mt-0.5">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('customer.orders.payment', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Payment Proof Upload --}}
                        <div class="mb-4">
                            <label for="payment_proof" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Bukti Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <label for="payment_proof"
                                   class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-orange-300 rounded-xl cursor-pointer bg-orange-50 hover:bg-orange-100 hover:border-orange-400 transition-colors group">
                                <svg class="w-7 h-7 text-orange-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-xs font-medium text-orange-600">Klik untuk unggah</p>
                                <p class="text-xs text-orange-400 mt-0.5">PNG, JPG – maks. 2MB</p>
                                <input type="file" id="payment_proof" name="payment_proof"
                                       class="hidden" accept="image/png,image/jpeg,image/jpg,application/pdf" required>
                            </label>
                            @error('payment_proof')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Payment Date --}}
                        <div class="mb-5">
                            <label for="payment_date" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Tanggal Transfer <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="payment_date" name="payment_date"
                                   value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                                   max="{{ now()->format('Y-m-d') }}"
                                   class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent @error('payment_date') border-red-400 @enderror"
                                   required>
                            @error('payment_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            @endif

            {{-- Cancel Order Form --}}
            @if(in_array($order->status, \App\Enums\OrderStatus::cancellableByCustomer()))
                <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Batalkan Pesanan</h2>
                            <p class="text-xs text-slate-500">Pesanan ini masih dapat dibatalkan</p>
                        </div>
                    </div>

                    {{-- Collapsible Cancel Form --}}
                    <div x-data="{ open: false }">
                        <button type="button"
                                @click="open = !open"
                                class="w-full text-sm font-semibold text-red-600 border border-red-200 hover:border-red-400 hover:bg-red-50 px-4 py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Batalkan Pesanan Ini
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="mt-4">
                            <div class="bg-red-50 border border-red-100 rounded-xl p-3 mb-4">
                                <p class="text-xs text-red-700 leading-relaxed">
                                    <span class="font-semibold">Perhatian!</span> Pembatalan pesanan tidak dapat dibatalkan kembali. Pastikan Anda yakin sebelum melanjutkan.
                                </p>
                            </div>

                            <form action="{{ route('customer.orders.cancel', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-4">
                                    <label for="cancel_reason" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                        Alasan Pembatalan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="cancel_reason" name="cancel_reason" rows="3"
                                              placeholder="Jelaskan alasan Anda membatalkan pesanan ini..."
                                              class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent resize-none @error('cancel_reason') border-red-400 @enderror"
                                              required>{{ old('cancel_reason') }}</textarea>
                                    @error('cancel_reason')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                        onclick="return confirm('Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.')"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Ya, Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>{{-- end right --}}

    </div>{{-- end 2-col grid --}}

</div>{{-- end content wrapper --}}
@endsection
