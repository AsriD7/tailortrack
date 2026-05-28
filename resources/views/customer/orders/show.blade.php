@extends('layouts.customer')

@section('title', 'Detail Pesanan #' . $order->order_code)

@section('content')
<div class="space-y-6">

    {{-- Order Header Banner --}}
    <div class="overflow-hidden rounded-[2rem] border border-tailor-purple/10 bg-white shadow-soft">
        <div class="relative brand-gradient p-5 text-white sm:p-7">
            <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-[radial-gradient(circle_at_top_right,rgba(240,179,79,0.35),transparent_55%)] sm:block"></div>
            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="min-w-0">
                    <div class="mb-2 flex flex-wrap items-center gap-3">
                        <h1 class="font-mono text-2xl font-black tracking-tight sm:text-3xl">{{ $order->order_code }}</h1>
                        <span class="inline-flex rounded-full bg-white/14 px-3 py-1 text-xs font-extrabold text-white ring-1 ring-white/20">
                            {{ $order->status->label() }}
                        </span>
                    </div>
                    <p class="text-sm font-medium text-white/75">
                        Dibuat pada {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB
                    </p>
                </div>

                <a href="{{ route('customer.orders.index') }}"
                   class="inline-flex items-center justify-center rounded-2xl bg-white/12 px-5 py-3 text-sm font-extrabold text-white ring-1 ring-white/20 transition hover:bg-white/18">
                    Kembali
                </a>
            </div>
        </div>

        <div class="p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            {{-- Progress steps --}}
            <div class="flex w-full items-center gap-1 overflow-x-auto pb-1">
                @php
                    $steps = [
                        ['key' => 'menunggu_konfirmasi', 'label' => 'Konfirmasi'],
                        ['key' => 'menunggu_pembayaran', 'label' => 'Pembayaran'],
                        ['key' => 'dibayar',             'label' => 'Dibayar'],
                        ['key' => 'diproses',            'label' => 'Diproses'],
                        ['key' => 'finishing',           'label' => 'Finishing'],
                        ['key' => 'siap_diambil',        'label' => 'Siap Diambil'],
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
                                    {{ $i < $currentIndex ? 'bg-tailor-purple text-white' : ($i === $currentIndex ? 'brand-gradient text-white ring-2 ring-tailor-soft' : 'bg-slate-100 text-slate-400') }}">
                                    @if($i < $currentIndex)
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </div>
                                <span class="text-xs mt-1 whitespace-nowrap {{ $i === $currentIndex ? 'text-tailor-purple font-semibold' : 'text-slate-400' }}">
                                    {{ $step['label'] }}
                                </span>
                            </div>
                            @if(!$loop->last)
                                <div class="w-6 h-0.5 mb-4 mx-1 {{ $i < $currentIndex ? 'bg-tailor-purple' : 'bg-slate-200' }}"></div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        </div>
    </div>

    {{-- Main 2-column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- ===== LEFT COLUMN (3/5) ===== --}}
        <div class="lg:col-span-3 space-y-6">

            {{-- Order Info Card --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
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
                    @include('orders._measurement_snapshot', ['order' => $order])
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
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
                <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informasi Penjahit
                </h2>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl brand-gradient flex items-center justify-center text-white font-bold text-lg shrink-0">
                        {{ mb_substr($order->tailor->tailorProfile->shop_name ?? $order->tailor->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-slate-800">{{ $order->tailor->tailorProfile->shop_name ?? '-' }}</p>
                        <p class="text-sm text-slate-500">{{ $order->tailor->name }}</p>
                        @if($order->tailor->tailorProfile->phone ?? false)
                            <a href="tel:{{ $order->tailor->tailorProfile->phone }}"
                               class="inline-flex items-center gap-1.5 text-tailor-purple text-xs font-medium mt-1 hover:underline">
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
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
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
                        <span class="text-lg font-bold {{ $order->total_price ? 'text-tailor-purple' : 'text-slate-400' }}">
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
            @if($order->orderImages->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
                    <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Referensi Desain
                        <span class="ml-auto text-xs font-normal text-slate-400 normal-case">{{ $order->orderImages->count() }} foto</span>
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($order->orderImages as $image)
                            <a href="{{ $image->imageUrl }}" target="_blank" rel="noopener"
                               class="group block aspect-square rounded-xl overflow-hidden border border-slate-200 hover:border-tailor-purple/40 transition-all hover:shadow-md">
                                <img src="{{ $image->imageUrl }}"
                                     alt="Referensi Desain {{ $loop->iteration }}"
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
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
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
                                        {{ $loop->first ? 'brand-gradient shadow-sm' : 'bg-slate-100' }}">
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

            @if($order->total_price)
                <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Ringkasan Pembayaran</h2>
                            <p class="text-xs text-slate-500">Pantau DP, pelunasan, dan sisa pembayaran</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                            <p class="text-xs text-slate-400">Total Tagihan</p>
                            <p class="mt-1 text-lg font-black text-slate-900">{{ $order->formattedTotalPrice() }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-3">
                                <p class="text-xs text-emerald-600">Sudah Terverifikasi</p>
                                <p class="mt-1 text-sm font-black text-emerald-800">{{ $order->formattedVerifiedPaymentsTotal() }}</p>
                            </div>
                            <div class="rounded-xl bg-orange-50 border border-orange-100 p-3">
                                <p class="text-xs text-orange-600">Sisa Bayar</p>
                                <p class="mt-1 text-sm font-black text-orange-800">{{ $order->formattedPaymentRemainingAmount() }}</p>
                            </div>
                        </div>
                    </div>

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
            @endif

            {{-- Payment Upload Form --}}
            @if($order->status === \App\Enums\OrderStatus::MenungguPembayaran)
                <div class="bg-white rounded-2xl shadow-soft border border-orange-200 p-6">
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

                    @php
                        $banks = config('payments.banks', []);
                        $defaultBank = old('bank_key', config('payments.default_bank', array_key_first($banks)));
                        $dpPercentage = max(1, min(100, (int) config('payments.dp_percentage', 50)));
                        $totalPayment = (float) $order->total_price;
                        $dpPayment = round($totalPayment * ($dpPercentage / 100));
                    @endphp

                    <div class="bg-orange-50 border border-orange-100 rounded-xl p-3 mb-4">
                        <p class="text-xs text-orange-700">Total harga final:</p>
                        <p class="text-lg font-bold text-orange-800 mt-0.5">
                            Rp {{ number_format($totalPayment, 0, ',', '.') }}
                        </p>
                    </div>

                    <form action="{{ route('customer.orders.payment', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Bank Account --}}
                        <div class="mb-4" data-bank-selector>
                            <label for="bank_key" class="block text-sm font-semibold text-slate-700 mb-2">
                                Pilih Rekening Tujuan <span class="text-red-500">*</span>
                            </label>
                            <select id="bank_key" name="bank_key"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent @error('bank_key') border-red-400 @enderror"
                                    data-bank-select>
                                @foreach($banks as $key => $bank)
                                    <option value="{{ $key }}" {{ $defaultBank === $key ? 'selected' : '' }}>
                                        {{ $bank['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bank_key')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <div class="mt-3">
                                @foreach($banks as $key => $bank)
                                    <div data-bank-card="{{ $key }}" class="{{ $defaultBank === $key ? '' : 'hidden' }} rounded-xl border border-orange-100 bg-orange-50 p-4">
                                        <p class="text-xs font-semibold text-orange-700 uppercase tracking-wide mb-3">Transfer ke rekening</p>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between gap-3">
                                                <span class="text-orange-700/70">Bank</span>
                                                <span class="font-semibold text-orange-900 text-right">{{ $bank['name'] }}</span>
                                            </div>
                                            <div class="flex justify-between gap-3">
                                                <span class="text-orange-700/70">No. Rekening</span>
                                                <span class="font-mono font-bold text-orange-900 text-right break-all">{{ $bank['account_number'] }}</span>
                                            </div>
                                            <div class="flex justify-between gap-3">
                                                <span class="text-orange-700/70">Atas Nama</span>
                                                <span class="font-semibold text-orange-900 text-right">{{ $bank['account_name'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Payment Type --}}
                        <div class="mb-4">
                            <p class="block text-sm font-semibold text-slate-700 mb-2">
                                Pilihan Pembayaran <span class="text-red-500">*</span>
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-3 cursor-pointer hover:border-orange-300 hover:bg-orange-50 transition-colors">
                                    <input type="radio" name="payment_type" value="full" class="mt-1 text-orange-500 focus:ring-orange-400" {{ old('payment_type', 'full') === 'full' ? 'checked' : '' }}>
                                    <span>
                                        <span class="block text-sm font-bold text-slate-800">Bayar Full</span>
                                        <span class="block text-xs text-slate-500 mt-0.5">Rp {{ number_format($totalPayment, 0, ',', '.') }}</span>
                                    </span>
                                </label>
                                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-3 cursor-pointer hover:border-orange-300 hover:bg-orange-50 transition-colors">
                                    <input type="radio" name="payment_type" value="dp" class="mt-1 text-orange-500 focus:ring-orange-400" {{ old('payment_type') === 'dp' ? 'checked' : '' }}>
                                    <span>
                                        <span class="block text-sm font-bold text-slate-800">DP / Panjar {{ $dpPercentage }}%</span>
                                        <span class="block text-xs text-slate-500 mt-0.5">Rp {{ number_format($dpPayment, 0, ',', '.') }}</span>
                                    </span>
                                </label>
                            </div>
                            @error('payment_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

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
                                       class="hidden" accept="image/png,image/jpeg,image/jpg" required data-payment-proof-input>
                            </label>
                            <div class="hidden mt-3 rounded-xl border border-slate-200 bg-slate-50 p-3" data-payment-proof-preview>
                                <p class="text-xs text-slate-400 mb-1">File dipilih</p>
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-slate-700 truncate" data-payment-proof-name></p>
                                    <a href="#" target="_blank" rel="noopener"
                                       class="flex-shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-tailor-purple hover:text-tailor-deep"
                                       data-payment-proof-link>
                                        Lihat preview
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
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

            @if($order->status === \App\Enums\OrderStatus::SiapDiambil && $order->hasVerifiedDpPayment() && $order->paymentRemainingAmount() > 0)
                <div class="bg-white rounded-2xl shadow-soft border border-orange-200 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m5 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l7-3 7 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">Upload Bukti Pelunasan</h2>
                            <p class="text-xs text-slate-500">Pesanan siap diambil setelah sisa pembayaran diverifikasi admin</p>
                        </div>
                    </div>

                    @php
                        $banks = config('payments.banks', []);
                        $defaultBank = old('bank_key', config('payments.default_bank', array_key_first($banks)));
                        $remainingPayment = $order->paymentRemainingAmount();
                    @endphp

                    @if($order->hasPendingFinalPayment())
                        <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">
                            <p class="text-sm font-bold text-blue-800">Pelunasan sedang diverifikasi admin.</p>
                            <p class="mt-1 text-xs leading-5 text-blue-700">Jika bukti ditolak, form upload ulang akan muncul kembali di sini.</p>
                        </div>
                    @else
                        <div class="bg-orange-50 border border-orange-100 rounded-xl p-3 mb-4">
                            <p class="text-xs text-orange-700">Sisa pembayaran:</p>
                            <p class="text-lg font-bold text-orange-800 mt-0.5">
                                Rp {{ number_format($remainingPayment, 0, ',', '.') }}
                            </p>
                        </div>

                        <form action="{{ route('customer.orders.payment', $order) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="payment_type" value="pelunasan">

                            <div class="mb-4" data-bank-selector>
                                <label for="final_bank_key" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Pilih Rekening Tujuan <span class="text-red-500">*</span>
                                </label>
                                <select id="final_bank_key" name="bank_key"
                                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent @error('bank_key') border-red-400 @enderror"
                                        data-bank-select>
                                    @foreach($banks as $key => $bank)
                                        <option value="{{ $key }}" {{ $defaultBank === $key ? 'selected' : '' }}>
                                            {{ $bank['name'] }} - {{ $bank['account_number'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="mt-3 space-y-2">
                                    @foreach($banks as $key => $bank)
                                        <div class="rounded-xl border border-orange-100 bg-orange-50 p-3 {{ $defaultBank === $key ? '' : 'hidden' }}" data-bank-card="{{ $key }}">
                                            <p class="text-xs font-semibold uppercase tracking-wide text-orange-500">{{ $bank['name'] }}</p>
                                            <p class="mt-1 font-mono text-lg font-black text-orange-900">{{ $bank['account_number'] }}</p>
                                            <p class="mt-1 text-xs font-semibold text-orange-700">a.n. {{ $bank['account_name'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                @error('bank_key')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="final_payment_proof" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Bukti Pelunasan <span class="text-red-500">*</span>
                                </label>
                                <label for="final_payment_proof"
                                       class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-orange-300 rounded-xl cursor-pointer bg-orange-50 hover:bg-orange-100 hover:border-orange-400 transition-colors group">
                                    <svg class="w-7 h-7 text-orange-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-xs font-medium text-orange-600">Klik untuk unggah</p>
                                    <p class="text-xs text-orange-400 mt-0.5">PNG, JPG - maks. 2MB</p>
                                    <input type="file" id="final_payment_proof" name="payment_proof"
                                           class="hidden" accept="image/png,image/jpeg,image/jpg" required data-payment-proof-input>
                                </label>
                                <div class="hidden mt-3 rounded-xl border border-slate-200 bg-slate-50 p-3" data-payment-proof-preview>
                                    <p class="text-xs text-slate-400 mb-1">File dipilih</p>
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="text-sm font-semibold text-slate-700 truncate" data-payment-proof-name></p>
                                        <a href="#" target="_blank" rel="noopener"
                                           class="flex-shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-tailor-purple hover:text-tailor-deep"
                                           data-payment-proof-link>
                                            Lihat preview
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                @error('payment_proof')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="final_payment_date" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Tanggal Transfer <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="final_payment_date" name="payment_date"
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Kirim Bukti Pelunasan
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            {{-- Cancel Order Form --}}
            @if(in_array($order->status, \App\Enums\OrderStatus::cancellableByCustomer()))
                <div class="bg-white rounded-2xl shadow-soft border border-red-100 p-6">
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

    {{-- ================================================================
         REVIEW SECTION (hanya tampil jika pesanan selesai)
         ================================================================ --}}
    @if($order->status === \App\Enums\OrderStatus::Selesai)
    <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
            <div class="w-9 h-9 bg-yellow-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-800">Berikan Ulasan</h2>
                <p class="text-xs text-slate-400 mt-0.5">Bagikan pengalaman Anda dengan penjahit ini</p>
            </div>
        </div>

        <div class="p-6">
            @if($order->review)
                {{-- Ulasan sudah ada --}}
                <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div>
                            <div class="flex items-center gap-1 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $order->review->rating ? 'text-yellow-400' : 'text-slate-200' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm font-bold text-yellow-700">{{ $order->review->rating_label }}</span>
                            </div>
                            <p class="text-xs text-slate-400">
                                Diulas pada {{ $order->review->created_at->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        {{-- Hapus ulasan --}}
                        <form action="{{ route('customer.reviews.destroy', $order->review) }}" method="POST"
                              onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-xs text-red-400 hover:text-red-600 hover:bg-red-50 px-2 py-1 rounded-lg transition-colors font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                    @if($order->review->comment)
                        <div class="bg-white rounded-xl p-4 border border-yellow-100">
                            <p class="text-sm text-slate-700 leading-relaxed">"{{ $order->review->comment }}"</p>
                        </div>
                    @else
                        <p class="text-sm text-slate-400 italic">Tidak ada komentar tambahan.</p>
                    @endif
                </div>

            @else
                {{-- Form beri ulasan --}}
                <form action="{{ route('customer.orders.review.store', $order) }}" method="POST" x-data="reviewForm()" @submit.prevent="submitForm">
                    @csrf

                    {{-- Bintang rating --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">
                            Rating Penjahit <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button"
                                    @click="setRating({{ $i }})"
                                    @mouseover="hovered = {{ $i }}"
                                    @mouseleave="hovered = 0"
                                    class="transition-transform hover:scale-110 focus:outline-none">
                                <svg class="w-10 h-10 transition-colors"
                                     :class="(hovered >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-slate-200'"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                            @endfor
                            <span class="ml-3 text-sm font-semibold text-slate-500" x-text="ratingLabel"></span>
                        </div>
                        <input type="hidden" name="rating" :value="rating">
                        @error('rating')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Komentar --}}
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Komentar <span class="text-slate-400 font-normal">(opsional)</span>
                        </label>
                        <textarea id="comment" name="comment" rows="3"
                                  placeholder="Ceritakan pengalaman Anda dengan penjahit ini: kualitas jahitan, ketepatan waktu, pelayanan..."
                                  maxlength="1000"
                                  class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent resize-none transition-shadow @error('comment') border-red-400 @enderror">{{ old('comment') }}</textarea>
                        <div class="flex justify-between mt-1">
                            @error('comment')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @else
                                <span></span>
                            @enderror
                            <p class="text-xs text-slate-400">Maks. 1000 karakter</p>
                        </div>
                    </div>

                    <button type="submit"
                            :disabled="rating === 0"
                            :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:opacity-90'"
                            class="inline-flex items-center gap-2 brand-gradient text-white px-6 py-3 rounded-xl font-bold text-sm transition-all shadow-md shadow-tailor-purple/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Kirim Ulasan
                    </button>
                </form>

                @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
                <script>
                    function reviewForm() {
                        return {
                            rating: {{ old('rating', 0) }},
                            hovered: 0,
                            get ratingLabel() {
                                const labels = ['', 'Sangat Kurang', 'Kurang', 'Cukup', 'Puas', 'Sangat Puas'];
                                return labels[this.hovered || this.rating] || 'Pilih rating';
                            },
                            setRating(val) { this.rating = val; },
                            submitForm() {
                                if (this.rating === 0) return;
                                this.$el.submit();
                            }
                        }
                    }
                </script>
                @endpush
            @endif
        </div>
    </div>
    @endif

</div>{{-- end content wrapper --}}
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-bank-selector]').forEach((wrapper) => {
            const select = wrapper.querySelector('[data-bank-select]');
            const cards = wrapper.querySelectorAll('[data-bank-card]');

            const syncBankCard = () => {
                cards.forEach((card) => {
                    card.classList.toggle('hidden', card.dataset.bankCard !== select.value);
                });
            };

            select.addEventListener('change', syncBankCard);
            syncBankCard();
        });

        document.querySelectorAll('[data-payment-proof-input]').forEach((input) => {
            const form = input.closest('form');
            const preview = form.querySelector('[data-payment-proof-preview]');
            const fileName = form.querySelector('[data-payment-proof-name]');
            const previewLink = form.querySelector('[data-payment-proof-link]');
            let objectUrl = null;

            input.addEventListener('change', () => {
                if (objectUrl) {
                    URL.revokeObjectURL(objectUrl);
                    objectUrl = null;
                }

                const file = input.files && input.files[0];
                if (!file) {
                    preview.classList.add('hidden');
                    fileName.textContent = '';
                    previewLink.removeAttribute('href');
                    return;
                }

                objectUrl = URL.createObjectURL(file);
                fileName.textContent = file.name;
                previewLink.href = objectUrl;
                preview.classList.remove('hidden');
            });
        });
    });
</script>
@endpush
