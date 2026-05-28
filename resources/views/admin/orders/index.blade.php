@extends('layouts.app')

@section('title', 'Semua Pesanan')
@section('page-title', 'Semua Pesanan')
@section('page-subtitle', 'Pantau seluruh pesanan di sistem')

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

@section('content')
{{-- Filter Bar --}}
<div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-4 mb-6">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode order..."
            class="px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold w-48">
        <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold bg-white">
            <option value="">Semua Status</option>
            @foreach($statuses as $status)
                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="brand-gradient text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90">Filter</button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-left">
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Kode Order</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Customer</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Penjahit</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Item</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Total</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Tanggal</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <span class="font-mono text-xs bg-tailor-soft text-tailor-purple px-2 py-1 rounded font-semibold">{{ $order->order_code }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($order->customer->name ?? '?', 0, 1)) }}
                            </div>
                            <span class="text-slate-700 font-medium truncate max-w-[100px]">{{ $order->customer->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600 truncate max-w-[100px]">{{ $order->tailor->tailorProfile->shop_name ?? $order->tailor->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-slate-700 font-medium">{{ $order->item_name }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                    </td>
                    <td class="px-5 py-3.5 font-semibold text-slate-700">
                        @if($order->total_price)
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        @elseif($order->estimated_price)
                            <span class="text-slate-400">~Rp {{ number_format($order->estimated_price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-slate-300">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-slate-200 transition-colors">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center">
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <p class="text-slate-500 text-sm">Belum ada pesanan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
