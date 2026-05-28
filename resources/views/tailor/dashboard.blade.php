@extends('layouts.app')

@section('title', 'Dashboard Penjahit')
@section('page-title', 'Dashboard Penjahit')
@section('page-subtitle', 'Pantau antrean, progress, dan pendapatan toko')

@section('page-actions')
    <a href="{{ route('tailor.orders.index') }}" class="rounded-2xl brand-gradient px-4 py-2.5 text-sm font-extrabold text-white shadow-soft">
        Kelola Pesanan
    </a>
@endsection

@section('content')
@php
    $runningOrders = ($stats['diproses'] ?? 0) + ($stats['finishing'] ?? 0) + ($stats['siap_diambil'] ?? 0);
    $statCards = [
        ['label' => 'Total Pesanan', 'value' => $stats['total'] ?? 0, 'note' => 'Semua pesanan', 'tone' => 'text-tailor-purple bg-tailor-soft'],
        ['label' => 'Menunggu Konfirmasi', 'value' => $stats['menunggu_konfirmasi'] ?? 0, 'note' => 'Perlu dicek', 'tone' => 'text-amber-700 bg-amber-50'],
        ['label' => 'Sedang Berjalan', 'value' => $runningOrders, 'note' => 'Proses sampai siap ambil', 'tone' => 'text-blue-700 bg-blue-50'],
        ['label' => 'Selesai', 'value' => $stats['selesai'] ?? 0, 'note' => 'Telah selesai', 'tone' => 'text-emerald-700 bg-emerald-50'],
    ];
@endphp

@if(!$tailorProfile || !$tailorProfile->shop_name)
    <section class="mb-8 rounded-3xl border border-amber-200 bg-amber-50 p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-black text-amber-800">Profil toko belum lengkap</p>
                <p class="mt-1 text-sm leading-7 text-amber-700">Lengkapi profil toko agar pelanggan bisa menemukan dan memesan layanan kamu.</p>
            </div>
            <a href="{{ route('tailor.profile.edit') }}" class="rounded-2xl bg-amber-500 px-5 py-3 text-center text-sm font-extrabold text-white">
                Lengkapi Profil
            </a>
        </div>
    </section>
@elseif($tailorProfile && $tailorProfile->shop_name && !$tailorProfile->is_verified)
    <section class="mb-8 rounded-3xl border border-blue-200 bg-blue-50 p-5">
        <p class="font-black text-blue-800">Profil belum tampil di publik</p>
        <p class="mt-1 text-sm leading-7 text-blue-700">Profil toko sudah diisi, tetapi belum aktif di pencarian customer.</p>
    </section>
@endif

<section class="mb-8 rounded-[2rem] bg-tailor-cream p-5 shadow-sm ring-1 ring-tailor-purple/10 sm:p-7">
    <div class="grid gap-6 lg:grid-cols-[1fr_360px] lg:items-center">
        <div>
            <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-black text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                Ringkasan Toko
            </span>
            <h1 class="mt-5 text-3xl font-black text-tailor-deep sm:text-4xl">
                {{ $tailorProfile?->shop_name ?? 'Toko Jahit Kamu' }}
            </h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                Kelola order masuk, kapasitas antrean, dan progress jahitan dari satu dashboard.
            </p>
        </div>

        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-tailor-purple/55">Pendapatan Selesai</p>
            <p class="mt-3 text-3xl font-black text-emerald-600">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
            <p class="mt-2 text-xs font-semibold text-slate-500">Dihitung dari pesanan selesai</p>
        </div>
    </div>
</section>

<section class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach($statCards as $card)
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-bold text-slate-500">{{ $card['label'] }}</p>
                    <p class="mt-2 text-3xl font-black text-tailor-deep">{{ $card['value'] }}</p>
                    <p class="mt-1 text-xs font-semibold text-slate-400">{{ $card['note'] }}</p>
                </div>
                <div class="grid h-12 w-12 place-items-center rounded-2xl {{ $card['tone'] }}">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 9h6M9 13h4M5 3h14v18l-3-2-3 2-3-2-3 2-2-1.5V3z"/>
                    </svg>
                </div>
            </div>
        </div>
    @endforeach
</section>

<section class="mb-8 grid gap-4 lg:grid-cols-3">
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-tailor-purple/10">
        <p class="text-sm font-bold text-slate-500">Antrean Aktif</p>
        <p class="mt-2 text-3xl font-black text-tailor-deep">
            {{ $stats['active_orders'] ?? 0 }}{{ $tailorProfile?->max_active_orders ? ' / ' . $tailorProfile->max_active_orders : '' }}
        </p>
        <p class="mt-1 text-xs font-semibold text-slate-400">Pesanan belum selesai</p>
    </div>
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-tailor-purple/10">
        <p class="text-sm font-bold text-slate-500">Pesanan Minggu Ini</p>
        <p class="mt-2 text-3xl font-black text-tailor-deep">
            {{ $stats['weekly_orders'] ?? 0 }}{{ $tailorProfile?->max_weekly_orders ? ' / ' . $tailorProfile->max_weekly_orders : '' }}
        </p>
        <p class="mt-1 text-xs font-semibold text-slate-400">Berdasarkan minggu berjalan</p>
    </div>
    <div class="rounded-3xl p-6 shadow-sm ring-1 {{ ($stats['is_at_capacity'] ?? false) ? 'bg-red-50 ring-red-100' : 'bg-emerald-50 ring-emerald-100' }}">
        <p class="text-sm font-bold {{ ($stats['is_at_capacity'] ?? false) ? 'text-red-600' : 'text-emerald-700' }}">Status Kapasitas</p>
        <p class="mt-2 text-2xl font-black {{ ($stats['is_at_capacity'] ?? false) ? 'text-red-700' : 'text-emerald-700' }}">
            {{ ($stats['is_at_capacity'] ?? false) ? 'Antrean Penuh' : 'Masih Menerima' }}
        </p>
        <p class="mt-1 text-xs font-semibold {{ ($stats['is_at_capacity'] ?? false) ? 'text-red-500' : 'text-emerald-600' }}">
            Estimasi {{ $tailorProfile?->estimated_processing_days ? $tailorProfile->estimated_processing_days . ' hari' : 'belum diatur' }}
        </p>
    </div>
</section>

<section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-tailor-purple/10">
    <div class="flex items-center justify-between gap-4 border-b border-tailor-purple/10 px-5 py-4 sm:px-6">
        <div>
            <h2 class="font-black text-tailor-deep">Pesanan Terbaru</h2>
            <p class="mt-1 text-xs font-semibold text-slate-500">Pesanan terkini dari pelanggan</p>
        </div>
        <a href="{{ route('tailor.orders.index') }}" class="text-sm font-black text-tailor-purple">Lihat Semua</a>
    </div>

    @if($recentOrders->isEmpty())
        <div class="p-10 text-center sm:p-14">
            <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-tailor-soft text-tailor-purple">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 9h6M9 13h4M5 3h14v18l-3-2-3 2-3-2-3 2-2-1.5V3z"/>
                </svg>
            </div>
            <h3 class="mt-5 text-xl font-black text-tailor-deep">Belum ada pesanan masuk</h3>
            <p class="mx-auto mt-2 max-w-md text-sm leading-7 text-slate-500">Pesanan pelanggan akan tampil setelah profil toko aktif.</p>
        </div>
    @else
        <div class="divide-y divide-tailor-purple/10">
            @foreach($recentOrders as $order)
                <a href="{{ route('tailor.orders.show', $order) }}" class="block px-5 py-4 transition hover:bg-tailor-cream sm:px-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-tailor-soft px-3 py-1 font-mono text-xs font-black text-tailor-purple">{{ $order->order_code }}</span>
                                <span class="rounded-full px-3 py-1 text-xs font-black {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                            </div>
                            <p class="mt-3 truncate font-black text-tailor-deep">{{ $order->item_name }}</p>
                            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $order->customer->name ?? '-' }}</p>
                        </div>
                        <div class="sm:text-right">
                            @if($order->total_price)
                                <p class="font-black text-emerald-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            @elseif($order->estimated_price)
                                <p class="font-black text-tailor-deep">Rp {{ number_format($order->estimated_price, 0, ',', '.') }}</p>
                            @else
                                <p class="text-sm font-semibold text-slate-400">Belum ditetapkan</p>
                            @endif
                            <p class="mt-1 text-xs font-semibold text-slate-400">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>
@endsection
