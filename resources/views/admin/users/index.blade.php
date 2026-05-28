@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Kelola seluruh pengguna yang terdaftar di platform')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('admin.tailors.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.tailors*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Penjahit
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'customer']) }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.users*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Customer
    </a>
    <a href="{{ route('admin.price-lists.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.price-lists*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
        </svg>
        Daftar Harga
    </a>
    <a href="{{ route('admin.orders.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.orders*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Semua Pesanan
    </a>
    <a href="{{ route('admin.payments.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.payments*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        Pembayaran
    </a>
@endsection

@section('content')
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Role Filter Tabs --}}
    <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-1.5 mb-6 inline-flex gap-1">
        <a href="{{ route('admin.users.index') }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ !request('role') ? 'brand-gradient text-white shadow-sm' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-50' }}">
            Semua
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'customer']) }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ request('role') === 'customer' ? 'brand-gradient text-white shadow-sm' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-50' }}">
            Customer
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'tailor']) }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ request('role') === 'tailor' ? 'brand-gradient text-white shadow-sm' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-50' }}">
            Penjahit
        </a>
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ request('role') === 'admin' ? 'brand-gradient text-white shadow-sm' : 'text-slate-600 hover:text-slate-800 hover:bg-slate-50' }}">
            Admin
        </a>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6 mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3">
            @if(request('role'))
                <input type="hidden" name="role" value="{{ request('role') }}">
            @endif
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau email pengguna..."
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent">
            </div>
            <button type="submit"
                    class="brand-gradient text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity whitespace-nowrap">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index', array_filter(['role' => request('role')])) }}"
                   class="bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors whitespace-nowrap text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">
                Daftar Pengguna
                <span class="ml-2 text-sm font-normal text-slate-500">({{ $users->total() }} total)</span>
            </h3>
        </div>

        @if($users->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <p class="text-sm font-medium">Tidak ada data pengguna</p>
                <p class="text-xs mt-1">Coba ubah filter pencarian Anda</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Bergabung</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0
                                            @if($user->role === 'admin') bg-red-500
                                            @elseif($user->role === 'tailor') bg-gradient-to-br from-tailor-purple to-tailor-deep
                                            @else bg-gradient-to-br from-emerald-500 to-teal-600
                                            @endif">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $roleColor = match($user->role) {
                                            'admin' => 'bg-red-100 text-red-700',
                                            'tailor' => 'bg-tailor-soft text-tailor-purple',
                                            default => 'bg-emerald-100 text-emerald-700',
                                        };
                                        $roleLabel = match($user->role) {
                                            'admin' => 'Admin',
                                            'tailor' => 'Penjahit',
                                            default => 'Customer',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleColor }}">
                                        {{ $roleLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $user->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-slate-200 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                              onsubmit="return confirm('Hapus pengguna {{ addslashes($user->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-200 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
