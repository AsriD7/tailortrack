@extends('layouts.app')

@section('title', 'Pesanan Masuk')
@section('page-title', 'Pesanan Masuk')
@section('page-subtitle', 'Kelola pesanan dan update progress jahitan')

@section('page-actions')
    <a href="{{ route('tailor.dashboard') }}" class="hidden rounded-2xl bg-tailor-soft px-4 py-2.5 text-sm font-extrabold text-tailor-purple sm:inline-flex">
        Dashboard
    </a>
@endsection

@section('content')
@php
    $waiting = $orders->getCollection()->where('status.value', 'menunggu_konfirmasi')->count();
    $running = $orders->getCollection()->whereIn('status.value', ['diproses', 'finishing', 'siap_diambil'])->count();
    $done = $orders->getCollection()->where('status.value', 'selesai')->count();
@endphp

<section class="mb-8 rounded-[2rem] bg-tailor-cream p-5 shadow-sm ring-1 ring-tailor-purple/10 sm:p-7">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-black text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                Workflow Penjahit
            </span>
            <h1 class="mt-5 text-3xl font-black text-tailor-deep sm:text-4xl">Kelola pesanan pelanggan.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                Buka detail pesanan untuk konfirmasi harga, lihat pembayaran, dan update progress jahitan.
            </p>
        </div>
        <div class="grid grid-cols-3 gap-3 sm:min-w-[360px]">
            <div class="rounded-2xl bg-white p-4 text-center shadow-sm ring-1 ring-tailor-purple/10">
                <p class="text-2xl font-black text-amber-600">{{ $waiting }}</p>
                <p class="mt-1 text-[11px] font-bold text-slate-500">Menunggu</p>
            </div>
            <div class="rounded-2xl bg-white p-4 text-center shadow-sm ring-1 ring-tailor-purple/10">
                <p class="text-2xl font-black text-tailor-purple">{{ $running }}</p>
                <p class="mt-1 text-[11px] font-bold text-slate-500">Berjalan</p>
            </div>
            <div class="rounded-2xl bg-white p-4 text-center shadow-sm ring-1 ring-tailor-purple/10">
                <p class="text-2xl font-black text-emerald-600">{{ $done }}</p>
                <p class="mt-1 text-[11px] font-bold text-slate-500">Selesai</p>
            </div>
        </div>
    </div>
</section>

<section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-tailor-purple/10">
    <div class="flex flex-col gap-2 border-b border-tailor-purple/10 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h2 class="font-black text-tailor-deep">Daftar Pesanan</h2>
            <p class="mt-1 text-xs font-semibold text-slate-500">{{ $orders->total() }} pesanan total</p>
        </div>
    </div>

    @if($orders->count() > 0)
        <div class="md:hidden divide-y divide-tailor-purple/10">
            @foreach($orders as $order)
                <a href="{{ route('tailor.orders.show', $order) }}" class="block p-5 transition hover:bg-tailor-cream">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <span class="rounded-full bg-tailor-soft px-3 py-1 font-mono text-xs font-black text-tailor-purple">{{ $order->order_code }}</span>
                            <h3 class="mt-3 truncate font-black text-tailor-deep">{{ $order->item_name }}</h3>
                            <p class="mt-1 truncate text-sm font-semibold text-slate-500">
                                {{ $order->customer->name ?? '-' }} / {{ $order->size ?? '-' }} / {{ $order->quantity }} pcs
                            </p>
                        </div>
                        <span class="shrink-0 rounded-full px-3 py-1 text-xs font-black {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-tailor-cream p-3">
                            <p class="text-xs font-bold text-slate-400">Estimasi</p>
                            <p class="mt-1 text-sm font-black text-tailor-deep">
                                {{ $order->estimated_price ? 'Rp ' . number_format($order->estimated_price, 0, ',', '.') : 'Belum ada' }}
                            </p>
                        </div>
                        <div class="rounded-2xl bg-tailor-cream p-3">
                            <p class="text-xs font-bold text-slate-400">Deadline</p>
                            <p class="mt-1 text-sm font-black {{ $order->deadline && $order->deadline->isPast() && $order->status->value !== 'selesai' ? 'text-red-600' : 'text-tailor-deep' }}">
                                {{ $order->deadline?->format('d M Y') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-3">
                        <p class="text-xs font-semibold text-slate-400">{{ $order->created_at->format('d M Y') }}</p>
                        <span class="text-xs font-black text-tailor-purple">Kelola</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-tailor-purple/10 bg-tailor-cream">
                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Kode</th>
                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Customer</th>
                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Item</th>
                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Ukuran</th>
                        <th class="px-5 py-4 text-right text-xs font-black uppercase tracking-[0.14em] text-slate-500">Estimasi</th>
                        <th class="px-5 py-4 text-right text-xs font-black uppercase tracking-[0.14em] text-slate-500">Total</th>
                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Status</th>
                        <th class="px-5 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-500">Tanggal</th>
                        <th class="px-5 py-4 text-right text-xs font-black uppercase tracking-[0.14em] text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-tailor-purple/10">
                    @foreach($orders as $order)
                        <tr class="transition hover:bg-tailor-cream">
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-tailor-soft px-3 py-1 font-mono text-xs font-black text-tailor-purple">{{ $order->order_code }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-9 w-9 shrink-0 place-items-center rounded-2xl brand-gradient text-xs font-black text-white">
                                        {{ strtoupper(substr($order->customer->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <p class="font-black text-tailor-deep">{{ $order->customer->name ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <p class="max-w-[180px] truncate font-black text-tailor-deep" title="{{ $order->item_name }}">{{ $order->item_name }}</p>
                                @if($order->category)
                                    <p class="mt-1 text-xs font-semibold text-slate-500">{{ $order->category }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">{{ $order->size ?? '-' }}</span>
                                <span class="ml-1 text-xs font-semibold text-slate-500">x{{ $order->quantity }}</span>
                            </td>
                            <td class="px-5 py-4 text-right font-black text-tailor-deep">
                                {{ $order->estimated_price ? 'Rp ' . number_format($order->estimated_price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-5 py-4 text-right font-black text-emerald-600">
                                {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-black {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                            </td>
                            <td class="px-5 py-4 text-xs font-semibold text-slate-500">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('tailor.orders.show', $order) }}" class="rounded-2xl bg-tailor-soft px-4 py-2 text-xs font-black text-tailor-purple">
                                    Kelola
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="border-t border-tailor-purple/10 px-5 py-4">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="p-10 text-center sm:p-14">
            <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-tailor-soft text-tailor-purple">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 9h6M9 13h4M5 3h14v18l-3-2-3 2-3-2-3 2-2-1.5V3z"/>
                </svg>
            </div>
            <h3 class="mt-5 text-xl font-black text-tailor-deep">Belum ada pesanan</h3>
            <p class="mx-auto mt-2 max-w-md text-sm leading-7 text-slate-500">Pesanan pelanggan akan tampil di sini setelah profil toko aktif.</p>
        </div>
    @endif
</section>
@endsection
