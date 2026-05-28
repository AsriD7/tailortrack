@extends('layouts.customer')

@section('title', 'Dashboard - TailorTrack')

@section('content')
@php
    $statCards = [
        ['label' => 'Total Pesanan', 'value' => $stats['total'] ?? 0, 'tone' => 'bg-tailor-soft text-tailor-purple'],
        ['label' => 'Menunggu Bayar', 'value' => $stats['menunggu_pembayaran'] ?? 0, 'tone' => 'bg-amber-50 text-amber-700'],
        ['label' => 'Diproses', 'value' => ($stats['diproses'] ?? 0) + ($stats['finishing'] ?? 0) + ($stats['siap_diambil'] ?? 0), 'tone' => 'bg-blue-50 text-blue-700'],
        ['label' => 'Selesai', 'value' => $stats['selesai'] ?? 0, 'tone' => 'bg-emerald-50 text-emerald-700'],
    ];
@endphp

<section class="mb-8 rounded-[2rem] bg-tailor-cream p-5 shadow-sm ring-1 ring-tailor-purple/10 sm:p-7">
    <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
            <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-black text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                Dashboard Customer
            </span>
            <h1 class="mt-5 text-3xl font-black leading-tight text-tailor-deep sm:text-4xl">
                Halo, {{ auth()->user()->name }}
            </h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600 sm:text-base">
                Pantau pesanan jahit, selesaikan pembayaran, dan temukan penjahit yang cocok untuk pesanan berikutnya.
            </p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
            <a href="{{ route('tailors.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl brand-gradient px-6 py-3 text-sm font-extrabold text-white shadow-soft">
                Buat Pesanan Baru
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ route('customer.orders.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-extrabold text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                Pesanan Saya
            </a>
        </div>
    </div>
</section>

<section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach($statCards as $card)
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-bold text-slate-500">{{ $card['label'] }}</p>
                    <p class="mt-2 text-3xl font-black text-tailor-deep">{{ $card['value'] }}</p>
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

@if(($stats['menunggu_pembayaran'] ?? 0) > 0)
    <section class="mb-8 rounded-3xl border border-amber-200 bg-amber-50 p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-black text-amber-800">{{ $stats['menunggu_pembayaran'] }} pesanan menunggu pembayaran</p>
                <p class="mt-1 text-sm leading-6 text-amber-700">Selesaikan pembayaran agar penjahit bisa lanjut memproses pesanan.</p>
            </div>
            <a href="{{ route('customer.orders.index') }}" class="rounded-2xl bg-amber-500 px-5 py-3 text-center text-sm font-extrabold text-white">
                Bayar Sekarang
            </a>
        </div>
    </section>
@endif

<div class="grid gap-8 lg:grid-cols-[1fr_360px]">
    <div class="space-y-8">
        <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-tailor-purple/10">
            <div class="flex items-center justify-between gap-4 border-b border-tailor-purple/10 px-5 py-4 sm:px-6">
                <div>
                    <h2 class="font-black text-tailor-deep">Pesanan Terbaru</h2>
                    <p class="mt-1 text-xs font-semibold text-slate-500">Pantau status pesanan jahit kamu</p>
                </div>
                <a href="{{ route('customer.orders.index') }}" class="text-sm font-black text-tailor-purple">Lihat Semua</a>
            </div>

            @forelse($recentOrders as $order)
                <a href="{{ route('customer.orders.show', $order) }}" class="block border-b border-tailor-purple/10 px-5 py-4 transition last:border-b-0 hover:bg-tailor-cream sm:px-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-tailor-soft px-3 py-1 font-mono text-xs font-black text-tailor-purple">{{ $order->order_code }}</span>
                                <span class="rounded-full px-3 py-1 text-xs font-black {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                            </div>
                            <h3 class="mt-3 truncate font-black text-tailor-deep">{{ $order->item_name }}</h3>
                            <p class="mt-1 truncate text-sm font-semibold text-slate-500">
                                {{ $order->tailor->tailorProfile->shop_name ?? $order->tailor->name ?? '-' }}
                            </p>
                        </div>
                        <div class="sm:text-right">
                            @if($order->total_price)
                                <p class="font-black text-emerald-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            @elseif($order->estimated_price)
                                <p class="font-black text-tailor-deep">Rp {{ number_format($order->estimated_price, 0, ',', '.') }}</p>
                            @else
                                <p class="text-sm font-semibold text-slate-400">Estimasi belum ada</p>
                            @endif
                            <p class="mt-1 text-xs font-semibold text-slate-400">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-10 text-center">
                    <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-tailor-soft text-tailor-purple">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 9h6M9 13h4M5 3h14v18l-3-2-3 2-3-2-3 2-2-1.5V3z"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 font-black text-tailor-deep">Belum ada pesanan</h3>
                    <p class="mx-auto mt-2 max-w-sm text-sm leading-7 text-slate-500">Pilih penjahit dan buat pesanan pertama kamu sekarang.</p>
                    <a href="{{ route('tailors.index') }}" class="mt-6 inline-flex rounded-2xl brand-gradient px-5 py-3 text-sm font-extrabold text-white shadow-soft">
                        Cari Penjahit
                    </a>
                </div>
            @endforelse
        </section>

        <section>
            <div class="mb-4 flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-black text-tailor-deep">Rekomendasi Penjahit</h2>
                    <p class="mt-1 text-xs font-semibold text-slate-500">Penjahit terverifikasi yang siap menerima pesanan</p>
                </div>
                <a href="{{ route('tailors.index') }}" class="text-sm font-black text-tailor-purple">Lihat Semua</a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @forelse($featuredTailors as $tailor)
                    @php
                        $profile = $tailor->tailorProfile;
                        $shopName = $profile->shop_name ?? $tailor->name;
                        $words = preg_split('/\s+/', trim($shopName));
                        $initials = strtoupper(substr($words[0] ?? 'T', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                    @endphp
                    <a href="{{ route('tailors.show', $tailor) }}" class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10 transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="flex gap-4">
                            @if($profile && $profile->photo)
                                <img src="{{ Storage::url($profile->photo) }}" alt="{{ $shopName }}" class="h-14 w-14 rounded-2xl object-cover ring-4 ring-tailor-soft">
                            @else
                                <div class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl brand-gradient text-lg font-black text-white ring-4 ring-tailor-soft">
                                    {{ $initials }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h3 class="truncate font-black text-tailor-deep">{{ $shopName }}</h3>
                                <p class="mt-1 truncate text-sm font-semibold text-slate-500">{{ $profile->specialization ?? 'Jasa Jahit Custom' }}</p>
                                <p class="mt-2 text-xs font-bold text-tailor-purple">{{ $tailor->portfolios_count ?? $tailor->portfolios->count() }} portfolio</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="rounded-3xl border border-dashed border-tailor-purple/20 bg-tailor-cream p-8 text-center sm:col-span-2">
                        <p class="font-black text-tailor-deep">Belum ada rekomendasi penjahit.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <aside class="space-y-5">
        <section class="rounded-3xl brand-gradient p-6 text-white shadow-soft">
            <p class="text-sm font-bold text-white/70">Profil Customer</p>
            <div class="mt-4 flex items-center gap-4">
                <div class="grid h-14 w-14 place-items-center rounded-2xl bg-white/15 text-xl font-black">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate font-black">{{ auth()->user()->name }}</p>
                    <p class="truncate text-sm font-semibold text-white/65">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-white/10 p-4 text-center">
                    <p class="text-2xl font-black">{{ $stats['total'] ?? 0 }}</p>
                    <p class="text-xs font-semibold text-white/65">Total</p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4 text-center">
                    <p class="text-2xl font-black">{{ $stats['selesai'] ?? 0 }}</p>
                    <p class="text-xs font-semibold text-white/65">Selesai</p>
                </div>
            </div>
            <a href="{{ route('customer.profile.edit') }}" class="mt-5 block rounded-2xl bg-white px-5 py-3 text-center text-sm font-extrabold text-tailor-purple">
                Edit Profil
            </a>
        </section>

        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-tailor-purple/10">
            <h2 class="font-black text-tailor-deep">Aksi Cepat</h2>
            <div class="mt-4 space-y-3">
                <a href="{{ route('tailors.index') }}" class="flex items-center justify-between rounded-2xl bg-tailor-cream px-4 py-3 text-sm font-black text-tailor-purple">
                    Buat Pesanan Baru
                    <span>+</span>
                </a>
                <a href="{{ route('customer.orders.index') }}" class="flex items-center justify-between rounded-2xl bg-tailor-cream px-4 py-3 text-sm font-black text-tailor-purple">
                    Semua Pesanan
                    <span>&gt;</span>
                </a>
                <a href="{{ route('price-lists.index') }}" class="flex items-center justify-between rounded-2xl bg-tailor-cream px-4 py-3 text-sm font-black text-tailor-purple">
                    Daftar Harga
                    <span>&gt;</span>
                </a>
            </div>
        </section>

        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-tailor-purple/10">
            <h2 class="font-black text-tailor-deep">Cara Memesan</h2>
            <div class="mt-5 space-y-4">
                @foreach(['Pilih penjahit', 'Isi detail pesanan', 'Bayar dan pantau progress'] as $index => $step)
                    <div class="flex gap-3">
                        <div class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-tailor-purple text-xs font-black text-white">{{ $index + 1 }}</div>
                        <p class="pt-1 text-sm font-bold text-slate-600">{{ $step }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </aside>
</div>
@endsection
