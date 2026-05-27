@extends('layouts.app')

@section('title', 'Detail User')
@section('page-title', 'Detail User')
@section('page-subtitle', $user->name)

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
    <a href="{{ route('admin.price-lists.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.price-lists*') ? 'active bg-white/15 text-white' : '' }}">
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
    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
    @if($user->id !== auth()->id())
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
        @csrf @method('DELETE')
        <button class="flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Hapus Akun
        </button>
    </form>
    @endif
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Kolom Kiri: Info User --}}
    <div class="space-y-6">
        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-20 h-20 rounded-full gradient-brand flex items-center justify-center text-white text-3xl font-bold mb-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                <p class="text-slate-500 text-sm">{{ $user->email }}</p>
                <span class="mt-2 inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $user->role->badgeColor() }}">
                    {{ $user->role->label() }}
                </span>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">Telepon</p>
                        <p class="font-medium text-slate-700">{{ $user->phone ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">Alamat</p>
                        <p class="font-medium text-slate-700">{{ $user->address ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">Bergabung</p>
                        <p class="font-medium text-slate-700">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tailor Profile (jika penjahit) --}}
        @if($user->isTailor() && $user->tailorProfile)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Profil Toko</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-slate-400 text-xs">Nama Toko</p>
                    <p class="font-semibold text-slate-800">{{ $user->tailorProfile->shop_name }}</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs">Spesialisasi</p>
                    <p class="font-medium text-slate-700">{{ $user->tailorProfile->specialization ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs">Pengalaman</p>
                    <p class="font-medium text-slate-700">{{ $user->tailorProfile->experience_years ? $user->tailorProfile->experience_years . ' tahun' : '-' }}</p>
                </div>
                <div class="flex gap-2 pt-1">
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->tailorProfile->is_verified ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $user->tailorProfile->is_verified ? 'Tampil di Publik' : 'Disembunyikan' }}
                    </span>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->tailorProfile->is_available ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $user->tailorProfile->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.tailors.show', $user) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Kelola Profil Penjahit →</a>
            </div>
        </div>
        @endif
    </div>

    {{-- Kolom Kanan: Riwayat Order --}}
    <div class="lg:col-span-2 space-y-6">
        @if($user->isCustomer())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Riwayat Pesanan Customer</h3>
            @if($user->customerOrders->isEmpty())
                <div class="text-center py-8">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <p class="text-slate-500 text-sm">Belum ada pesanan</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left">
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide rounded-l-lg">Kode Order</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Item</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Harga</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide rounded-r-lg">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($user->customerOrders as $order)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded font-semibold hover:bg-indigo-100">{{ $order->order_code }}</a>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-700">{{ $order->item_name }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                                </td>
                                <td class="px-4 py-3 text-slate-600">Rp {{ number_format($order->total_price ?? $order->estimated_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-slate-400 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @endif

        @if($user->isTailor())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Pesanan yang Ditangani</h3>
            @if($user->tailorOrders->isEmpty())
                <div class="text-center py-8">
                    <p class="text-slate-500 text-sm">Belum ada pesanan yang ditangani</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left">
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide rounded-l-lg">Kode Order</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Customer</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Status</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide rounded-r-lg">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($user->tailorOrders as $order)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded font-semibold hover:bg-indigo-100">{{ $order->order_code }}</a>
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $order->customer->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">{{ $order->status->label() }}</span>
                                </td>
                                <td class="px-4 py-3 text-slate-600">Rp {{ number_format($order->total_price ?? $order->estimated_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
