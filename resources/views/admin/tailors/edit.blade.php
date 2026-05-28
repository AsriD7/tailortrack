@extends('layouts.app')

@section('title', 'Edit Penjahit - ' . $tailor->name)
@section('page-title', 'Edit Penjahit')
@section('page-subtitle', 'Perbarui informasi penjahit: ' . $tailor->name)

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('admin.tailors.index') }}"
       class="nav-link {{ request()->routeIs('admin.tailors*') ? 'active' : '' }}">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Penjahit
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'customer']) }}"
       class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Customer
    </a>
    <a href="{{ route('admin.price-lists.index') }}"
       class="nav-link {{ request()->routeIs('admin.price-lists*') ? 'active' : '' }}">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
        </svg>
        Daftar Harga
    </a>
    <a href="{{ route('admin.orders.index') }}"
       class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Semua Pesanan
    </a>
    <a href="{{ route('admin.payments.index') }}"
       class="nav-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        Pembayaran
    </a>
@endsection

@section('page-actions')
    <a href="{{ route('admin.tailors.show', $tailor) }}"
       class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')
    <div class="max-w-3xl">
        <form method="POST" action="{{ route('admin.tailors.update', $tailor) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Account Info --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 brand-gradient rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800">Informasi Akun</h3>
                        <p class="text-xs text-slate-500">Data dasar penjahit</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $tailor->name) }}" required
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('name') ? 'border-red-400 bg-red-50' : '' }}"
                               placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $tailor->email) }}" required
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}"
                               placeholder="email@example.com">
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $tailor->phone) }}"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : '' }}"
                               placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat</label>
                        <textarea name="address" rows="2"
                                  class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('address') ? 'border-red-400 bg-red-50' : '' }}"
                                  placeholder="Alamat lengkap">{{ old('address', $tailor->address) }}</textarea>
                        @error('address')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Shop Info --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800">Informasi Toko</h3>
                        <p class="text-xs text-slate-500">Profil toko dan keahlian penjahit</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Toko</label>
                        <input type="text" name="shop_name" value="{{ old('shop_name', $tailor->tailorProfile?->shop_name) }}"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('shop_name') ? 'border-red-400 bg-red-50' : '' }}"
                               placeholder="Nama toko atau usaha">
                        @error('shop_name')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Spesialisasi</label>
                        <input type="text" name="specialization" value="{{ old('specialization', $tailor->tailorProfile?->specialization) }}"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('specialization') ? 'border-red-400 bg-red-50' : '' }}"
                               placeholder="cth: Kebaya, Jas, Batik">
                        @error('specialization')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('description') ? 'border-red-400 bg-red-50' : '' }}"
                                  placeholder="Ceritakan tentang keahlian dan pengalaman penjahit...">{{ old('description', $tailor->tailorProfile?->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2 border-t border-slate-100 pt-5">
                        <h4 class="text-sm font-semibold text-slate-800 mb-3">Jadwal & Kapasitas Pesanan</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Maks. Pesanan Aktif</label>
                                <input type="number" name="max_active_orders" min="1" max="999" value="{{ old('max_active_orders', $tailor->tailorProfile?->max_active_orders) }}"
                                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('max_active_orders') ? 'border-red-400 bg-red-50' : '' }}"
                                       placeholder="10">
                                @error('max_active_orders')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Maks. / Minggu</label>
                                <input type="number" name="max_weekly_orders" min="1" max="999" value="{{ old('max_weekly_orders', $tailor->tailorProfile?->max_weekly_orders) }}"
                                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('max_weekly_orders') ? 'border-red-400 bg-red-50' : '' }}"
                                       placeholder="5">
                                @error('max_weekly_orders')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Estimasi Pengerjaan</label>
                                <input type="number" name="estimated_processing_days" min="1" max="365" value="{{ old('estimated_processing_days', $tailor->tailorProfile?->estimated_processing_days) }}"
                                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent {{ $errors->has('estimated_processing_days') ? 'border-red-400 bg-red-50' : '' }}"
                                       placeholder="7 hari">
                                @error('estimated_processing_days')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Hari Kerja</label>
                            @php
                                $selectedWorkingDays = collect(old('working_days', $tailor->tailorProfile?->working_days ?? [1, 2, 3, 4, 5, 6]))
                                    ->map(fn($day) => (int) $day)
                                    ->all();
                            @endphp
                            <div class="flex flex-wrap gap-2">
                                @foreach(\App\Models\TailorProfile::WORKING_DAY_LABELS as $day => $label)
                                    <label class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-600 hover:border-tailor-purple/30 hover:text-tailor-purple cursor-pointer">
                                        <input type="checkbox" name="working_days[]" value="{{ $day }}"
                                               class="rounded border-slate-300 text-tailor-purple focus:ring-tailor-gold"
                                               {{ in_array($day, $selectedWorkingDays, true) ? 'checked' : '' }}>
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                            @error('working_days')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            @error('working_days.*')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                            Layanan yang Diterima
                        </label>
                        @php
                            $selectedPriceLists = old('price_list_ids', $tailor->priceLists->pluck('id')->all());
                        @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 rounded-xl border border-slate-200 p-3">
                            @foreach($priceLists as $priceList)
                                <label class="flex items-start gap-3 rounded-lg px-3 py-2 hover:bg-slate-50 cursor-pointer">
                                    <input type="checkbox"
                                           name="price_list_ids[]"
                                           value="{{ $priceList->id }}"
                                           class="mt-1 rounded border-slate-300 text-tailor-purple focus:ring-tailor-gold"
                                           {{ in_array($priceList->id, $selectedPriceLists) ? 'checked' : '' }}>
                                    <span>
                                        <span class="block text-sm font-semibold text-slate-700">{{ $priceList->name }}</span>
                                        <span class="block text-xs text-slate-400">{{ $priceList->category }} &middot; {{ $priceList->formattedBasePrice() }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Hanya layanan yang dipilih yang muncul saat customer membuat pesanan ke penjahit ini.</p>
                        @error('price_list_ids')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        @error('price_list_ids.*')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.tailors.show', $tailor) }}"
                   class="bg-slate-100 text-slate-700 px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="brand-gradient text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
