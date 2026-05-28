@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_code)
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', 'Kelola dan pantau status pesanan')

@section('page-actions')
    <a href="{{ route('tailor.orders.index') }}"
       class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
@endsection

@section('sidebar-nav')
    <a href="{{ route('tailor.dashboard') }}"
       class="nav-link {{ request()->routeIs('tailor.dashboard*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('tailor.profile.edit') }}"
       class="nav-link {{ request()->routeIs('tailor.profile*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        Profil Toko
    </a>
    <a href="{{ route('tailor.portfolios.index') }}"
       class="nav-link {{ request()->routeIs('tailor.portfolios*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Portfolio
    </a>
    <a href="{{ route('tailor.orders.index') }}"
       class="nav-link {{ request()->routeIs('tailor.orders*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
        </svg>
        Pesanan Masuk
    </a>
@endsection

@section('content')
@php
    $progressSteps = \App\Enums\OrderStatus::tailorProgressStatuses();
    $currentProgressIndex = collect($progressSteps)->search(fn($status) => $status === $order->status);
    $canCompleteOrder = $order->isFullyPaid();
    $availableProgressStatuses = collect($order->status->availableTailorProgressTargets())
        ->reject(fn($status) => $status === \App\Enums\OrderStatus::Selesai && !$canCompleteOrder)
        ->values()
        ->all();
@endphp
<div class="space-y-5">

    {{-- Order Header --}}
    <div class="overflow-hidden rounded-[2rem] border border-tailor-purple/10 bg-white shadow-soft">
        <div class="relative brand-gradient p-5 text-white sm:p-7">
            <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-[radial-gradient(circle_at_top_right,rgba(240,179,79,0.35),transparent_55%)] sm:block"></div>
            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div class="min-w-0">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-tailor-gold">Kelola Pesanan</p>
                    <div class="mt-2 flex flex-wrap items-center gap-3">
                        <h1 class="font-mono text-2xl font-black tracking-tight sm:text-3xl">{{ $order->order_code }}</h1>
                        <span class="inline-flex rounded-full bg-white/14 px-3 py-1 text-xs font-extrabold text-white ring-1 ring-white/20">
                            {{ $order->status->label() }}
                        </span>
                    </div>
                    <p class="mt-2 text-sm font-medium text-white/75">
                        Diterima {{ $order->created_at->diffForHumans() }} - {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                @if($order->deadline)
                    <div class="rounded-2xl bg-white/12 px-5 py-3 text-left ring-1 ring-white/20 lg:text-right">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-tailor-gold">Deadline</p>
                        <p class="mt-1 text-sm font-extrabold {{ $order->deadline->isPast() && $order->status->value !== 'selesai' ? 'text-red-100' : 'text-white' }}">
                            {{ $order->deadline->format('d M Y') }}
                            @if($order->deadline->isPast() && $order->status->value !== 'selesai')
                                <span class="block text-xs font-semibold text-red-100 sm:inline">(Terlewat)</span>
                            @elseif($order->deadline->isFuture())
                                <span class="block text-xs font-semibold text-white/65 sm:inline">({{ $order->deadline->diffForHumans() }})</span>
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Progress Overview --}}
    @if($currentProgressIndex !== false)
        <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-5">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <h2 class="text-sm font-semibold text-slate-800">Progres Pengerjaan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Langkah kerja yang terlihat oleh customer</p>
                </div>
                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">
                    {{ $order->status->label() }}
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                @foreach($progressSteps as $index => $status)
                    @php
                        $isDone = $index < $currentProgressIndex;
                        $isCurrent = $index === $currentProgressIndex;
                    @endphp
                    <div class="rounded-xl border p-3 {{ $isCurrent ? 'border-tailor-purple/20 bg-tailor-soft' : ($isDone ? 'border-emerald-100 bg-emerald-50' : 'border-slate-100 bg-slate-50') }}">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $isCurrent ? 'bg-tailor-purple text-white' : ($isDone ? 'bg-emerald-500 text-white' : 'bg-white text-slate-400 border border-slate-200') }}">
                                @if($isDone)
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            <p class="text-xs font-semibold {{ $isCurrent ? 'text-tailor-purple' : ($isDone ? 'text-emerald-700' : 'text-slate-500') }}">
                                {{ $status->label() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Main Content: 2-column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- LEFT COLUMN (3/5) --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Customer Info --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-slate-700">Informasi Customer</h2>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-tailor-purple to-tailor-deep flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">
                                {{ strtoupper(substr($order->customer->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $order->customer->name ?? '-' }}</p>
                            <p class="text-xs text-slate-500">{{ $order->customer->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        @if($order->customer->phone ?? null)
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-slate-400">Telepon</p>
                                    <p class="text-sm text-slate-700 font-medium">{{ $order->customer->phone }}</p>
                                </div>
                            </div>
                        @endif
                        @if($order->customer->address ?? null)
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-slate-400">Alamat</p>
                                    <p class="text-sm text-slate-700">{{ $order->customer->address }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Order Info --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2.5">
                    <div class="w-7 h-7 bg-tailor-soft rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-tailor-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-slate-700">Detail Pesanan</h2>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-slate-400 mb-0.5">Nama Item</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $order->item_name }}</p>
                        </div>
                        @if($order->category)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Kategori</p>
                                <p class="text-sm font-medium text-slate-700">{{ $order->category }}</p>
                            </div>
                        @endif
                        @if($order->size)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Ukuran</p>
                                <p class="text-sm font-medium text-slate-700">{{ $order->size }}</p>
                            </div>
                        @endif
                        @if($order->quantity)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Jumlah</p>
                                <p class="text-sm font-medium text-slate-700">{{ $order->quantity }} pcs</p>
                            </div>
                        @endif
                        @if($order->deadline)
                            <div>
                                <p class="text-xs text-slate-400 mb-0.5">Deadline</p>
                                <p class="text-sm font-medium text-slate-700">{{ $order->deadline->format('d M Y') }}</p>
                            </div>
                        @endif
                    </div>

                    @include('orders._measurement_snapshot', ['order' => $order, 'wrapperClass' => 'mb-4'])

                    @if($order->description)
                        <div class="mb-4">
                            <p class="text-xs text-slate-400 mb-1">Deskripsi / Keterangan</p>
                            <div class="bg-slate-50 rounded-xl p-3 text-sm text-slate-700 leading-relaxed">
                                {{ $order->description }}
                            </div>
                        </div>
                    @endif

                    @if($order->note)
                        <div class="mb-4">
                            <p class="text-xs text-slate-400 mb-1">Catatan Tambahan</p>
                            <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 text-sm text-amber-800 leading-relaxed flex gap-2">
                                <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                {{ $order->note }}
                            </div>
                        </div>
                    @endif

                    {{-- Pricing --}}
                    <div class="border-t border-slate-100 pt-4 mt-4 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-500">Estimasi Harga</span>
                            <span class="text-sm font-semibold text-slate-700">
                                Rp {{ number_format($order->estimated_price, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($order->total_price)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Total Harga Konfirmasi</span>
                                <span class="text-base font-bold text-tailor-purple">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Reference Images --}}
            @if($order->orderImages->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2.5">
                        <div class="w-7 h-7 bg-rose-100 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-sm font-semibold text-slate-700">Referensi Desain</h2>
                        <span class="text-xs text-slate-400">({{ $order->orderImages->count() }} gambar)</span>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-3 gap-2.5">
                            @foreach($order->orderImages as $img)
                                <a href="{{ $img->imageUrl }}" target="_blank"
                                   class="relative aspect-square rounded-xl overflow-hidden bg-slate-100 hover:ring-2 hover:ring-tailor-purple hover:ring-offset-1 transition-all group">
                                    <img src="{{ $img->imageUrl }}"
                                         alt="Referensi Desain {{ $loop->iteration }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Payment Status --}}
            @if($order->total_price)
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2.5">
                        <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-sm font-semibold text-slate-700">Status Pembayaran</h2>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <p class="text-xs text-slate-400">Total Tagihan</p>
                                <p class="mt-1 text-sm font-black text-slate-900">{{ $order->formattedTotalPrice() }}</p>
                            </div>
                            <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-3">
                                <p class="text-xs text-emerald-600">Terverifikasi</p>
                                <p class="mt-1 text-sm font-black text-emerald-800">{{ $order->formattedVerifiedPaymentsTotal() }}</p>
                            </div>
                            <div class="rounded-xl bg-orange-50 border border-orange-100 p-3">
                                <p class="text-xs text-orange-600">Sisa Bayar</p>
                                <p class="mt-1 text-sm font-black text-orange-800">{{ $order->formattedPaymentRemainingAmount() }}</p>
                            </div>
                        </div>

                        @if(!$canCompleteOrder && $order->status === \App\Enums\OrderStatus::SiapDiambil)
                            <div class="mt-3 rounded-xl border border-orange-100 bg-orange-50 p-3 text-xs leading-5 text-orange-700">
                                Customer perlu upload pelunasan, lalu admin memverifikasi sebelum pesanan dapat ditandai selesai.
                            </div>
                        @endif

                        @if($order->payments->isNotEmpty())
                            <div class="mt-4 space-y-2">
                                @foreach($order->payments as $payment)
                                    <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-100 bg-white p-3">
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-800">{{ $payment->payment_type_label }}</p>
                                            <p class="text-xs text-slate-500">{{ $payment->formattedAmount() }} - {{ $payment->payment_date?->format('d M Y') ?? '-' }}</p>
                                        </div>
                                        <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-bold {{ $payment->status->badgeColor() }}">
                                            {{ $payment->status->label() }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        {{-- RIGHT COLUMN (2/5) --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Confirm Price Form (only if menunggu_konfirmasi) --}}
            @if($order->status->value === 'menunggu_konfirmasi')
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2.5">
                        <div class="w-7 h-7 bg-tailor-soft rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-tailor-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-slate-700">Konfirmasi Harga</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Tetapkan harga akhir untuk pesanan ini</p>
                        </div>
                    </div>
                    <div class="p-5">
                        {{-- Estimated Price Reference --}}
                        <div class="bg-tailor-soft border border-tailor-purple/10 rounded-xl p-3 mb-4 flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-tailor-purple flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs text-tailor-purple font-medium">Estimasi dari Customer</p>
                                <p class="text-sm font-bold text-tailor-deep">
                                    Rp {{ number_format($order->estimated_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <form action="{{ route('tailor.orders.confirm-price', $order) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="total_price" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Harga Final <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500 font-medium">Rp</span>
                                    <input type="number" id="total_price" name="total_price"
                                           value="{{ old('total_price', $order->estimated_price) }}"
                                           min="0" step="1000"
                                           placeholder="0"
                                           class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('total_price') border-red-300 @enderror">
                                </div>
                                @error('total_price')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="confirm_note" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Catatan (Opsional)
                                </label>
                                <textarea id="confirm_note" name="confirm_note" rows="3"
                                          placeholder="Rincian harga atau pesan untuk customer..."
                                          class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent resize-none">{{ old('confirm_note') }}</textarea>
                                @error('confirm_note')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full brand-gradient text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Konfirmasi Harga
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Cancel/Reject Form --}}
                <div class="bg-white rounded-2xl shadow-soft border border-red-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-red-100 flex items-center gap-2.5">
                        <div class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-slate-700">Tolak Pesanan</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Pesanan akan dibatalkan dan customer diberitahu</p>
                        </div>
                    </div>
                    <div class="p-5">
                        <form action="{{ route('tailor.orders.cancel', $order) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menolak pesanan ini? Tindakan ini tidak dapat diurungkan.')">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="cancel_reason" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Alasan Penolakan <span class="text-red-500">*</span>
                                </label>
                                <textarea id="cancel_reason" name="cancel_reason" rows="3"
                                          placeholder="Jelaskan alasan penolakan pesanan ini kepada customer..."
                                          class="w-full px-4 py-2.5 border border-red-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none @error('cancel_reason') border-red-400 @enderror">{{ old('cancel_reason') }}</textarea>
                                @error('cancel_reason')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="w-full bg-red-500 text-white py-2.5 rounded-lg font-semibold text-sm hover:bg-red-600 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Tolak Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Update Progress --}}
            @if(count($availableProgressStatuses) > 0)
                <div class="bg-white rounded-2xl shadow-soft border border-emerald-100 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-emerald-100 flex items-center gap-2.5">
                        <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-slate-700">Update Progres</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Pilih status terbaru sesuai kondisi pesanan</p>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 mb-4">
                            <div class="flex gap-2">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-emerald-700">
                                    Penjahit bisa melompat ke langkah yang lebih maju jika progres memang sudah melewati tahap sebelumnya.
                                </p>
                            </div>
                        </div>

                        @if(!$canCompleteOrder && $order->status === \App\Enums\OrderStatus::SiapDiambil)
                            <div class="bg-orange-50 border border-orange-100 rounded-xl p-3 mb-4">
                                <p class="text-xs text-orange-700">
                                    Status selesai akan aktif setelah sisa pembayaran {{ $order->formattedPaymentRemainingAmount() }} diverifikasi admin.
                                </p>
                            </div>
                        @endif

                        <form action="{{ route('tailor.orders.update-status', $order) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <div>
                                <p class="block text-xs font-semibold text-slate-700 mb-2">Status Baru</p>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($availableProgressStatuses as $status)
                                        <label class="flex items-center gap-3 rounded-xl border border-slate-200 p-3 cursor-pointer hover:border-emerald-300 hover:bg-emerald-50/60 transition-colors">
                                            <input type="radio" name="status" value="{{ $status->value }}" class="text-emerald-600 focus:ring-emerald-500" {{ old('status', $availableProgressStatuses[0]->value) === $status->value ? 'checked' : '' }}>
                                            <span class="flex-1 min-w-0">
                                                <span class="block text-sm font-semibold text-slate-800">{{ $status->label() }}</span>
                                                <span class="block text-xs text-slate-500 mt-0.5">{{ $status->defaultTrackingDescription() }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('status')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="completion_note" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Catatan untuk Customer (Opsional)
                                </label>
                                <textarea id="completion_note" name="description" rows="3"
                                          placeholder="Contoh: Jahitan sudah masuk finishing, tinggal pasang kancing dan setrika..."
                                          class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none">{{ old('description') }}</textarea>
                            </div>

                            <button type="submit"
                                    class="w-full bg-emerald-500 text-white py-3 rounded-lg font-semibold text-sm hover:bg-emerald-600 transition-colors flex items-center justify-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Simpan Progres
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Current Status Info (for non-actionable statuses) --}}
            @if(!in_array($order->status->value, ['menunggu_konfirmasi', 'diproses', 'finishing', 'siap_diambil']))
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-5">
                    <div class="text-center py-2">
                        @if($order->status->value === 'selesai')
                            <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-emerald-700">Pesanan Selesai</p>
                            <p class="text-xs text-slate-400 mt-1">Pesanan ini telah berhasil diselesaikan.</p>
                        @elseif($order->status->value === 'dibatalkan')
                            <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-red-700">Pesanan Dibatalkan</p>
                            <p class="text-xs text-slate-400 mt-1">Pesanan ini telah dibatalkan.</p>
                        @elseif($order->status->value === 'menunggu_pembayaran')
                            <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-orange-700">Menunggu Pembayaran</p>
                            <p class="text-xs text-slate-400 mt-1">Customer sedang melakukan pembayaran.</p>
                        @elseif($order->status->value === 'dibayar')
                            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-blue-700">Menunggu Verifikasi Admin</p>
                            <p class="text-xs text-slate-400 mt-1">Customer sudah upload bukti bayar. Pesanan bisa diproses setelah admin verifikasi.</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Tracking History --}}
            @if($order->trackingHistories->count() > 0)
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2.5">
                        <div class="w-7 h-7 bg-violet-100 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <h2 class="text-sm font-semibold text-slate-700">Riwayat Status</h2>
                    </div>
                    <div class="p-5">
                        <div class="space-y-0">
                            @foreach($order->trackingHistories->sortByDesc('created_at') as $tracking)
                                <div class="relative flex gap-3 {{ !$loop->last ? 'pb-5' : '' }}">
                                    {{-- Timeline Line --}}
                                    @if(!$loop->last)
                                        <div class="absolute left-3.5 top-7 bottom-0 w-px bg-slate-100"></div>
                                    @endif

                                    {{-- Timeline Dot --}}
                                    <div class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center mt-0.5 z-10
                                        {{ $loop->first ? 'bg-tailor-purple shadow-md shadow-tailor-purple/20' : 'bg-slate-100' }}">
                                        @if($loop->first)
                                            <div class="w-2.5 h-2.5 rounded-full bg-white"></div>
                                        @else
                                            <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <div>
                                                @php $trackStatus = \App\Enums\OrderStatus::tryFrom($tracking->status); @endphp
                                                @if($trackStatus)
                                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $trackStatus->badgeColor() }}">
                                                        {{ $trackStatus->label() }}
                                                    </span>
                                                @elseif($tracking->status)
                                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                                        {{ $tracking->status }}
                                                    </span>
                                                @endif
                                                @if($tracking->description)
                                                    <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ $tracking->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-xs text-slate-400 mt-1">
                                            {{ $tracking->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty tracking fallback: just show order creation --}}
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-slate-100 flex items-center gap-2.5">
                        <div class="w-7 h-7 bg-violet-100 rounded-lg flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <h2 class="text-sm font-semibold text-slate-700">Riwayat Status</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-7 h-7 rounded-full bg-tailor-purple shadow-md shadow-tailor-purple/20 flex items-center justify-center">
                                <div class="w-2.5 h-2.5 rounded-full bg-white"></div>
                            </div>
                            <div>
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">
                                    {{ $order->status->label() }}
                                </span>
                                <p class="text-xs text-slate-400 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
