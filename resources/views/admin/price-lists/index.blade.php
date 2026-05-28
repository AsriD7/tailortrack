@extends('layouts.app')

@section('title', 'Daftar Harga')
@section('page-title', 'Daftar Harga')
@section('page-subtitle', 'Kelola harga layanan jahit')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
        Dashboard
    </a>
    <a href="{{ route('admin.tailors.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.tailors*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Penjahit
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.users*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        Customer
    </a>
    <a href="{{ route('admin.price-lists.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium active bg-white/15">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Daftar Harga
    </a>
    <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.orders*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        Semua Pesanan
    </a>
    <a href="{{ route('admin.payments.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.payments*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        Pembayaran
    </a>
@endsection

@section('page-actions')
    <a href="{{ route('admin.price-lists.create') }}" class="flex items-center gap-2 brand-gradient text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Harga
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-left">
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Nama Layanan</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Kategori</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Harga Dasar</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide">Keterangan</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wide text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($priceLists as $item)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $item->name }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-tailor-soft text-tailor-purple">{{ $item->category }}</span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-emerald-700">Rp {{ number_format($item->base_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $item->description ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.price-lists.edit', $item) }}" class="flex items-center gap-1.5 bg-tailor-soft text-tailor-purple px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-tailor-soft transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.price-lists.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus harga ini?')">
                                @csrf @method('DELETE')
                                <button class="flex items-center gap-1.5 bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
                        </div>
                        <p class="text-slate-500 text-sm">Belum ada daftar harga.</p>
                        <a href="{{ route('admin.price-lists.create') }}" class="mt-3 inline-flex brand-gradient text-white px-4 py-2 rounded-lg text-sm font-semibold">Tambah Sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($priceLists->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $priceLists->links() }}</div>
    @endif
</div>
@endsection
