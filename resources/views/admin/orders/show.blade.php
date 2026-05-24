@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_code)
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', $order->order_code)

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
    <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg active bg-white/15 text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>Semua Pesanan
    </a>
    <a href="{{ route('admin.payments.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>Pembayaran
    </a>
@endsection

@section('page-actions')
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kolom Kiri --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Order Header Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Kode Pesanan</p>
                    <h2 class="font-mono text-xl font-bold text-indigo-700">{{ $order->order_code }}</h2>
                </div>
                <span class="inline-flex px-3 py-1.5 rounded-full text-sm font-semibold {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-slate-400 text-xs mb-0.5">Item</p>
                    <p class="font-semibold text-slate-800">{{ $order->item_name }}</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs mb-0.5">Kategori</p>
                    <p class="font-medium text-slate-700">{{ $order->category }}</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs mb-0.5">Ukuran</p>
                    <p class="font-medium text-slate-700">{{ $order->size }}</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs mb-0.5">Jumlah</p>
                    <p class="font-medium text-slate-700">{{ $order->quantity }} pcs</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs mb-0.5">Deadline</p>
                    <p class="font-medium text-slate-700">{{ $order->deadline ? $order->deadline->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs mb-0.5">Dibuat</p>
                    <p class="font-medium text-slate-700">{{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>

            @if($order->description)
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p class="text-slate-400 text-xs mb-1">Deskripsi</p>
                <p class="text-slate-700 text-sm">{{ $order->description }}</p>
            </div>
            @endif

            @if($order->note)
            <div class="mt-3">
                <p class="text-slate-400 text-xs mb-1">Catatan Tambahan</p>
                <p class="text-slate-700 text-sm">{{ $order->note }}</p>
            </div>
            @endif
        </div>

        {{-- Customer & Tailor Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    Customer
                </h3>
                <p class="font-semibold text-slate-800">{{ $order->customer->name }}</p>
                <p class="text-sm text-slate-500">{{ $order->customer->email }}</p>
                <p class="text-sm text-slate-500 mt-1">{{ $order->customer->phone ?? '-' }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-7 h-7 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/></svg>
                    </div>
                    Penjahit
                </h3>
                <p class="font-semibold text-slate-800">{{ $order->tailor->tailorProfile->shop_name ?? $order->tailor->name }}</p>
                <p class="text-sm text-slate-500">{{ $order->tailor->name }}</p>
                <p class="text-sm text-slate-500 mt-1">{{ $order->tailor->phone ?? '-' }}</p>
            </div>
        </div>

        {{-- Harga --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Informasi Harga</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Estimasi Harga</p>
                    <p class="text-xl font-bold text-slate-700">Rp {{ number_format($order->estimated_price ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-indigo-50 rounded-xl p-4">
                    <p class="text-xs text-indigo-400 mb-1">Harga Final (Penjahit)</p>
                    <p class="text-xl font-bold text-indigo-700">
                        {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Menunggu konfirmasi' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Gambar Referensi --}}
        @if($order->orderImages->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Gambar Referensi ({{ $order->orderImages->count() }})</h3>
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                @foreach($order->orderImages as $img)
                <a href="{{ $img->imageUrl }}" target="_blank">
                    <img src="{{ $img->imageUrl }}" alt="Referensi" class="w-full h-24 object-cover rounded-xl border border-slate-200 hover:opacity-80 transition-opacity">
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Pembayaran --}}
        @if($order->payment)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Bukti Pembayaran</h3>
            <div class="flex items-start gap-4">
                <a href="{{ $order->payment->paymentProofUrl }}" target="_blank">
                    <img src="{{ $order->payment->paymentProofUrl }}" alt="Bukti Bayar" class="w-32 h-32 object-cover rounded-xl border border-slate-200 hover:opacity-80 transition-opacity">
                </a>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Status Pembayaran</p>
                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $order->payment->status->badgeColor() }}">{{ $order->payment->status->label() }}</span>
                    @if($order->payment->payment_date)
                    <p class="mt-2 text-sm text-slate-500">Tanggal: {{ $order->payment->payment_date->format('d M Y') }}</p>
                    @endif
                    <div class="mt-3">
                        <a href="{{ route('admin.payments.show', $order->payment) }}" class="gradient-brand text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 inline-flex">
                            Kelola Pembayaran →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Pembatalan --}}
        @if($order->status->value === 'dibatalkan')
        <div class="bg-red-50 border border-red-100 rounded-2xl p-6">
            <h3 class="font-bold text-red-800 mb-3">Pesanan Dibatalkan</h3>
            <p class="text-sm text-red-600 mb-1"><strong>Dibatalkan oleh:</strong> {{ $order->cancelledBy->name ?? '-' }}</p>
            <p class="text-sm text-red-600 mb-1"><strong>Waktu:</strong> {{ $order->cancelled_at?->format('d M Y H:i') }}</p>
            <p class="text-sm text-red-600"><strong>Alasan:</strong> {{ $order->cancel_reason }}</p>
        </div>
        @endif
    </div>

    {{-- Kolom Kanan --}}
    <div class="space-y-6">
        {{-- Admin Cancel Order --}}
        @php $canCancel = $order->canBeCancelledBy(auth()->user()); @endphp
        @if($canCancel)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-1">Batalkan Pesanan</h3>
            <p class="text-xs text-slate-400 mb-4">Sebagai admin, Anda dapat membatalkan pesanan ini.</p>
            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alasan Pembatalan <span class="text-red-500">*</span></label>
                    <textarea name="cancel_reason" rows="3" required
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400 resize-none"
                        placeholder="Jelaskan alasan pembatalan..."></textarea>
                </div>
                <button type="submit" class="w-full bg-red-500 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-red-600 transition-colors">
                    Batalkan Pesanan
                </button>
            </form>
        </div>
        @endif

        {{-- Tracking History --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Riwayat Tracking</h3>
            @if($order->trackingHistories->isEmpty())
                <p class="text-slate-400 text-sm text-center py-4">Belum ada riwayat.</p>
            @else
            <div class="relative">
                <div class="absolute left-3.5 top-0 bottom-0 w-0.5 bg-slate-100"></div>
                <div class="space-y-4">
                    @foreach($order->trackingHistories as $track)
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
                            @if($track->updatedByUser)
                            <p class="text-xs text-slate-400">oleh: {{ $track->updatedByUser->name }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
