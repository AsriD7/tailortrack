@extends('layouts.app')

@section('title', 'Semua Pembayaran')
@section('page-title', 'Pembayaran')
@section('page-subtitle', 'Verifikasi bukti pembayaran customer')

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

@section('content')
{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
    <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-wrap items-center gap-3">
        <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
            <option value="">Semua Status</option>
            @foreach($statuses as $status)
                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
            @endforeach
        </select>
        <select name="payment_type" class="px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
            <option value="">Semua Jenis</option>
            <option value="full" {{ request('payment_type') === 'full' ? 'selected' : '' }}>Bayar Full</option>
            <option value="dp" {{ request('payment_type') === 'dp' ? 'selected' : '' }}>DP / Panjar</option>
        </select>
        <button type="submit" class="gradient-brand text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90">Filter</button>
        @if(request()->hasAny(['status', 'payment_type']))
            <a href="{{ route('admin.payments.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-left">
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Kode Order</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Customer</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Penjahit</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Jenis</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Nominal Bayar</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Tgl Bayar</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                    <th class="px-5 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payments as $payment)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <span class="font-mono text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded font-semibold">{{ $payment->order->order_code }}</span>
                    </td>
                    <td class="px-5 py-3.5 font-medium text-slate-700">{{ $payment->order->customer->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $payment->order->tailor->tailorProfile->shop_name ?? $payment->order->tailor->name ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $payment->payment_type === 'dp' ? 'bg-orange-100 text-orange-700' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ $payment->payment_type_label }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 font-semibold text-slate-800">
                        @if($payment->amount)
                            {{ $payment->formattedAmount() }}
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $payment->payment_date?->format('d M Y') ?? '-' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $payment->status->badgeColor() }}">{{ $payment->status->label() }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <a href="{{ route('admin.payments.show', $payment) }}" class="inline-flex items-center gap-1.5 gradient-brand text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:opacity-90 transition-opacity">
                            {{ $payment->status->value === 'pending' ? 'Verifikasi' : 'Detail' }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center">
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <p class="text-slate-500 text-sm">Belum ada data pembayaran.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
