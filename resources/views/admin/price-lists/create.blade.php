@extends('layouts.app')

@section('title', 'Tambah Daftar Harga')
@section('page-title', 'Tambah Daftar Harga')

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
    <a href="{{ route('admin.price-lists.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg active bg-white/15 text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>Daftar Harga
    </a>
    <a href="{{ route('admin.orders.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>Semua Pesanan
    </a>
    <a href="{{ route('admin.payments.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>Pembayaran
    </a>
@endsection

@section('page-actions')
    <a href="{{ route('admin.price-lists.index') }}" class="flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Informasi Layanan</h2>

        <form action="{{ route('admin.price-lists.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Layanan <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Contoh: Kemeja, Kebaya, Permak Celana">
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="category" class="w-full px-4 py-2.5 border {{ $errors->has('category') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach(['Atasan','Bawahan','Terusan','Perbaikan','Lainnya'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga Dasar (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">Rp</span>
                    <input type="number" name="base_price" value="{{ old('base_price') }}" min="0"
                        class="w-full pl-10 pr-4 py-2.5 border {{ $errors->has('base_price') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="45000">
                </div>
                @error('base_price')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Keterangan</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                    placeholder="Deskripsi singkat tentang layanan ini...">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex gap-3">
                <button type="submit" class="gradient-brand text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
                    Simpan Harga
                </button>
                <a href="{{ route('admin.price-lists.index') }}" class="bg-slate-100 text-slate-700 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-slate-200 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
