@extends('layouts.customer')

@section('title', 'Pesanan Saya')

@section('content')
@php
    $diproses = $orders->getCollection()->whereIn('status.value', ['diproses', 'finishing', 'siap_diambil'])->count();
    $selesai = $orders->getCollection()->where('status.value', 'selesai')->count();
    $menunggu = $orders->getCollection()->whereIn('status.value', ['menunggu_konfirmasi', 'menunggu_pembayaran'])->count();
@endphp

<section class="mb-8 rounded-[2rem] bg-tailor-cream p-5 shadow-sm ring-1 ring-tailor-purple/10 sm:p-7">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-black text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                Pesanan Saya
            </span>
            <h1 class="mt-5 text-3xl font-black text-tailor-deep sm:text-4xl">Kelola semua pesanan jahit.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Pantau status, cek pembayaran, dan lihat detail progress dari penjahit.</p>
        </div>
        <a href="{{ route('tailors.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl brand-gradient px-6 py-3 text-sm font-extrabold text-white shadow-soft">
            Buat Pesanan Baru
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>

<section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
        <p class="text-sm font-bold text-slate-500">Total Pesanan</p>
        <p class="mt-2 text-3xl font-black text-tailor-deep">{{ $orders->total() }}</p>
    </div>
    <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
        <p class="text-sm font-bold text-slate-500">Menunggu</p>
        <p class="mt-2 text-3xl font-black text-amber-600">{{ $menunggu }}</p>
    </div>
    <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
        <p class="text-sm font-bold text-slate-500">Berjalan</p>
        <p class="mt-2 text-3xl font-black text-tailor-purple">{{ $diproses }}</p>
    </div>
    <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
        <p class="text-sm font-bold text-slate-500">Selesai</p>
        <p class="mt-2 text-3xl font-black text-emerald-600">{{ $selesai }}</p>
    </div>
</section>

<section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-tailor-purple/10">
    <div class="border-b border-tailor-purple/10 px-5 py-4 sm:px-6">
        <h2 class="font-black text-tailor-deep">Daftar Pesanan</h2>
        <p class="mt-1 text-xs font-semibold text-slate-500">
            Menampilkan {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan
        </p>
    </div>

    @if($orders->isEmpty())
        <div class="p-10 text-center sm:p-14">
            <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-tailor-soft text-tailor-purple">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 9h6M9 13h4M5 3h14v18l-3-2-3 2-3-2-3 2-2-1.5V3z"/>
                </svg>
            </div>
            <h3 class="mt-5 text-xl font-black text-tailor-deep">Belum ada pesanan</h3>
            <p class="mx-auto mt-2 max-w-md text-sm leading-7 text-slate-500">Temukan penjahit terbaik dan buat pesanan pertama kamu sekarang.</p>
            <a href="{{ route('tailors.index') }}" class="mt-6 inline-flex rounded-2xl brand-gradient px-6 py-3 text-sm font-extrabold text-white shadow-soft">
                Cari Penjahit
            </a>
        </div>
    @else
        <div class="md:hidden divide-y divide-tailor-purple/10">
            @foreach($orders as $order)
                <a href="{{ route('customer.orders.show', $order) }}" class="block p-5 transition hover:bg-tailor-cream">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <span class="rounded-full bg-tailor-soft px-3 py-1 font-mono text-xs font-black text-tailor-purple">{{ $order->order_code }}</span>
                            <h3 class="mt-3 truncate font-black text-tailor-deep">{{ $order->item_name }}</h3>
                            <p class="mt-1 truncate text-sm font-semibold text-slate-500">{{ $order->tailor->tailorProfile->shop_name ?? $order->tailor->name }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-3 py-1 text-xs font-black {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-tailor-cream p-3">
                            <p class="text-xs font-bold text-slate-400">Harga</p>
                            <p class="mt-1 text-sm font-black text-tailor-deep">
                                @if($order->total_price)
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                @elseif($order->estimated_price)
                                    Rp {{ number_format($order->estimated_price, 0, ',', '.') }}
                                @else
                                    Menunggu
                                @endif
                            </p>
                        </div>
                        <div class="rounded-2xl bg-tailor-cream p-3">
                            <p class="text-xs font-bold text-slate-400">Deadline</p>
                            <p class="mt-1 text-sm font-black {{ $order->deadline && $order->deadline->isPast() && !in_array($order->status->value, ['selesai', 'dibatalkan']) ? 'text-red-600' : 'text-tailor-deep' }}">
                                {{ $order->deadline?->format('d M Y') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-3 text-xs font-semibold text-slate-500">
                        <span>{{ $order->size }} / {{ $order->quantity }} pcs / {{ $order->created_at->format('d M Y') }}</span>
                        <span class="font-black text-tailor-purple">Detail</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-tailor-purple/10 bg-tailor-cream">
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Kode</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Penjahit</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Item</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Ukuran</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-[0.14em] text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tailor-purple/10">
                    @foreach($orders as $order)
                        <tr class="transition hover:bg-tailor-cream">
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-tailor-soft px-3 py-1 font-mono text-xs font-black text-tailor-purple">{{ $order->order_code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-black text-tailor-deep">{{ $order->tailor->tailorProfile->shop_name ?? '-' }}</p>
                                <p class="text-xs font-semibold text-slate-500">{{ $order->tailor->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-black text-tailor-deep">{{ $order->item_name }}</p>
                                @if($order->category)
                                    <p class="text-xs font-semibold text-slate-500">{{ $order->category }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">{{ $order->size }}</span>
                                @if($order->quantity > 1)
                                    <span class="ml-1 text-xs font-semibold text-slate-500">x{{ $order->quantity }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-black text-tailor-deep">
                                @if($order->total_price)
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                @elseif($order->estimated_price)
                                    Rp {{ number_format($order->estimated_price, 0, ',', '.') }}
                                @else
                                    <span class="text-xs font-semibold text-slate-400">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-black {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-500">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('customer.orders.show', $order) }}" class="rounded-2xl bg-tailor-soft px-4 py-2 text-xs font-black text-tailor-purple">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="border-t border-tailor-purple/10 px-6 py-4">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
</section>
@endsection
