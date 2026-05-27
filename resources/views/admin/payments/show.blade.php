@extends('layouts.app')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Detail Pembayaran')
@section('page-subtitle', $payment->order->order_code)

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>Dashboard
    </a>
    <a href="{{ route('admin.tailors.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Penjahit
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>Customer
    </a>
    <a href="{{ route('admin.price-lists.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>Daftar Harga
    </a>
    <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>Semua Pesanan
    </a>
    <a href="{{ route('admin.payments.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg active bg-white/15 text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>Pembayaran
    </a>
@endsection

@section('page-actions')
    <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kolom Kiri: Detail Pembayaran --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Info Pesanan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-start justify-between mb-5">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Kode Pesanan</p>
                    <a href="{{ route('admin.orders.show', $payment->order) }}" class="font-mono text-xl font-bold text-indigo-700 hover:text-indigo-800">{{ $payment->order->order_code }}</a>
                </div>
                <span class="inline-flex px-3 py-1.5 rounded-full text-sm font-semibold {{ $payment->status->badgeColor() }}">{{ $payment->status->label() }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Customer Info --}}
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Customer</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-bold">
                            {{ strtoupper(substr($payment->order->customer->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $payment->order->customer->name }}</p>
                            <p class="text-slate-500 text-xs">{{ $payment->order->customer->email }}</p>
                            <p class="text-slate-400 text-xs">{{ $payment->order->customer->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tailor Info --}}
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Penjahit</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold">
                            {{ strtoupper(substr($payment->order->tailor->tailorProfile->shop_name ?? $payment->order->tailor->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $payment->order->tailor->tailorProfile->shop_name ?? $payment->order->tailor->name }}</p>
                            <p class="text-slate-500 text-xs">{{ $payment->order->tailor->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Harga --}}
            <div class="mt-5 pt-5 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Jenis Pembayaran</p>
                    <p class="font-bold text-slate-800">{{ $payment->payment_type_label }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Nominal Transfer</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $payment->formattedAmount() }}</p>
                </div>
                @if($payment->payment_date)
                <div class="sm:text-right">
                    <p class="text-xs text-slate-400 mb-1">Tanggal Pembayaran</p>
                    <p class="font-semibold text-slate-700">{{ $payment->payment_date->format('d M Y') }}</p>
                </div>
                @endif
            </div>

            <div class="mt-5 bg-slate-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Rekening Tujuan</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                    <div>
                        <p class="text-slate-400 text-xs">Bank</p>
                        <p class="font-semibold text-slate-700">{{ $payment->bank_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">No. Rekening</p>
                        <p class="font-mono font-semibold text-slate-700">{{ $payment->bank_account_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">Atas Nama</p>
                        <p class="font-semibold text-slate-700">{{ $payment->bank_account_name ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bukti Pembayaran --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Bukti Pembayaran</h3>
            <div class="flex flex-col items-center">
                <a href="{{ $payment->paymentProofUrl }}" target="_blank" class="block group">
                    <img src="{{ $payment->paymentProofUrl }}" alt="Bukti Pembayaran"
                        class="max-w-sm w-full rounded-2xl border-2 border-slate-200 shadow-sm group-hover:opacity-90 transition-opacity cursor-zoom-in">
                </a>
                <p class="mt-3 text-xs text-slate-400">Klik gambar untuk memperbesar</p>
                <a href="{{ $payment->paymentProofUrl }}" target="_blank"
                    class="mt-2 flex items-center gap-2 text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Buka di Tab Baru
                </a>
            </div>
        </div>

        {{-- Tracking History --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Riwayat Pesanan</h3>
            @if($payment->order->trackingHistories->isEmpty())
                <p class="text-slate-400 text-sm text-center py-4">Belum ada riwayat.</p>
            @else
            <div class="relative">
                <div class="absolute left-3.5 top-0 bottom-0 w-0.5 bg-slate-100"></div>
                <div class="space-y-4">
                    @foreach($payment->order->trackingHistories as $track)
                    <div class="relative flex gap-4">
                        <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0 z-10 border-2 border-white">
                            <div class="w-2.5 h-2.5 bg-indigo-500 rounded-full"></div>
                        </div>
                        <div class="flex-1 pb-1">
                            <p class="text-xs font-semibold text-indigo-700 mb-0.5">{{ \App\Enums\OrderStatus::tryFrom($track->status)?->label() ?? $track->status }}</p>
                            @if($track->description)
                            <p class="text-xs text-slate-600">{{ $track->description }}</p>
                            @endif
                            <p class="text-xs text-slate-400 mt-1">{{ $track->created_at?->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Kolom Kanan: Aksi Verifikasi --}}
    <div class="space-y-6">
        @if($payment->status->value === 'pending')
        {{-- Verify Button --}}
        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-emerald-800">Verifikasi Pembayaran</h3>
                    <p class="text-xs text-emerald-600">Bukti pembayaran valid</p>
                </div>
            </div>
            <p class="text-sm text-emerald-700 mb-4">Dengan menekan tombol ini, pembayaran {{ strtolower($payment->payment_type_label) }} akan diverifikasi dan pesanan masuk ke proses penjahit.</p>
            <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" onsubmit="return confirm('Verifikasi pembayaran ini?')">
                @csrf @method('PATCH')
                <button type="submit" class="w-full bg-emerald-500 text-white py-3 rounded-xl text-sm font-bold hover:bg-emerald-600 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Verifikasi Pembayaran
                </button>
            </form>
        </div>

        {{-- Reject Form --}}
        <div class="bg-red-50 border border-red-100 rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-red-800">Tolak Pembayaran</h3>
                    <p class="text-xs text-red-600">Bukti tidak valid / tidak sesuai</p>
                </div>
            </div>
            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" onsubmit="return confirm('Tolak pembayaran ini?')">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <label class="block text-sm font-semibold text-red-700 mb-1.5">Alasan Penolakan</label>
                    <textarea name="reject_reason" rows="3"
                        class="w-full px-4 py-2.5 border border-red-200 bg-white rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400 resize-none"
                        placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <button type="submit" class="w-full bg-red-500 text-white py-3 rounded-xl text-sm font-bold hover:bg-red-600 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Tolak Pembayaran
                </button>
            </form>
        </div>
        @else
        {{-- Sudah diproses --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 text-center">
            <div class="w-14 h-14 {{ $payment->status->value === 'verified' ? 'bg-emerald-100' : 'bg-red-100' }} rounded-full flex items-center justify-center mx-auto mb-3">
                @if($payment->status->value === 'verified')
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                @else
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                @endif
            </div>
            <span class="inline-flex px-3 py-1.5 rounded-full text-sm font-semibold {{ $payment->status->badgeColor() }}">{{ $payment->status->label() }}</span>
            <p class="text-sm text-slate-500 mt-3">Pembayaran ini telah diproses sebelumnya.</p>
        </div>
        @endif

        {{-- Info singkat --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-sm space-y-2">
            <div class="flex justify-between">
                <span class="text-slate-400">Pembayaran</span>
                <span class="font-medium text-slate-700">{{ $payment->payment_type_label }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Nominal</span>
                <span class="font-medium text-slate-700">{{ $payment->formattedAmount() }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Upload pada</span>
                <span class="font-medium text-slate-700">{{ $payment->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Item</span>
                <span class="font-medium text-slate-700">{{ $payment->order->item_name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Ukuran</span>
                <span class="font-medium text-slate-700">{{ $payment->order->size }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Jumlah</span>
                <span class="font-medium text-slate-700">{{ $payment->order->quantity }} pcs</span>
            </div>
        </div>
    </div>
</div>
@endsection
