@extends('layouts.app')

@section('title', 'Profil Toko')
@section('page-title', 'Profil Toko')
@section('page-subtitle', 'Kelola informasi pribadi dan profil toko Anda')

@section('sidebar-nav')
    <a href="{{ route('tailor.dashboard') }}"
       class="nav-link {{ request()->routeIs('tailor.dashboard*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('tailor.profile.edit') }}"
       class="nav-link {{ request()->routeIs('tailor.profile*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        Profil Toko
    </a>
    <a href="{{ route('tailor.portfolios.index') }}"
       class="nav-link {{ request()->routeIs('tailor.portfolios*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Portfolio
    </a>
    <a href="{{ route('tailor.orders.index') }}"
       class="nav-link {{ request()->routeIs('tailor.orders*') ? 'active' : '' }}">
        <svg class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
        </svg>
        Pesanan Masuk
    </a>
@endsection

@section('content')
@php
    $shopName = $profile->shop_name ?? 'Profil Toko Belum Lengkap';
    $isPublished = (bool) ($profile?->is_verified ?? false);
    $isAvailable = (bool) old('is_available', $profile->is_available ?? true);
    $selectedWorkingDays = collect(old('working_days', $profile->working_days ?? [1, 2, 3, 4, 5, 6]))
        ->map(fn($day) => (int) $day)
        ->all();
    $selectedWorkingDayLabels = collect($selectedWorkingDays)
        ->map(fn($day) => \App\Models\TailorProfile::WORKING_DAY_LABELS[$day] ?? null)
        ->filter()
        ->values();
@endphp
<div class="max-w-4xl mx-auto space-y-6">

    <section class="overflow-hidden rounded-[2rem] border border-tailor-purple/10 bg-white shadow-soft">
        <div class="relative brand-gradient p-5 text-white sm:p-7">
            <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-[radial-gradient(circle_at_top_right,rgba(240,179,79,0.35),transparent_55%)] sm:block"></div>
            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div class="flex min-w-0 items-start gap-4">
                    <div class="grid h-16 w-16 shrink-0 place-items-center overflow-hidden rounded-3xl bg-white/14 text-2xl font-black ring-1 ring-white/20">
                        @if($profile && $profile->profile_photo)
                            <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="{{ $shopName }}" class="h-full w-full object-cover">
                        @else
                            {{ mb_substr($shopName, 0, 1) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-tailor-gold">Profil Toko</p>
                        <h1 class="mt-2 truncate text-2xl font-black tracking-tight sm:text-3xl">{{ $shopName }}</h1>
                        <p class="mt-2 max-w-2xl text-sm font-medium leading-6 text-white/75">
                            Atur data toko, kapasitas, layanan, hari kerja, dan tanggal libur agar pesanan customer lebih akurat.
                        </p>
                    </div>
                </div>

                <button type="submit" form="tailorProfileForm"
                        class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-extrabold text-tailor-purple shadow-sm transition hover:bg-tailor-cream">
                    Simpan Profil
                </button>
            </div>
        </div>

        <div class="grid gap-3 p-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl bg-tailor-cream p-4 ring-1 ring-tailor-purple/10">
                <p class="text-xs font-bold text-slate-500">Publikasi</p>
                <p class="mt-1 text-sm font-black {{ $isPublished ? 'text-emerald-700' : 'text-amber-700' }}">
                    {{ $isPublished ? 'Tampil di Publik' : 'Disembunyikan' }}
                </p>
            </div>
            <div class="rounded-2xl bg-tailor-cream p-4 ring-1 ring-tailor-purple/10">
                <p class="text-xs font-bold text-slate-500">Ketersediaan</p>
                <p class="mt-1 text-sm font-black {{ $isAvailable ? 'text-tailor-purple' : 'text-slate-500' }}">
                    {{ $isAvailable ? 'Menerima Pesanan' : 'Tidak Menerima' }}
                </p>
            </div>
            <div class="rounded-2xl bg-tailor-cream p-4 ring-1 ring-tailor-purple/10">
                <p class="text-xs font-bold text-slate-500">Kapasitas</p>
                <p class="mt-1 text-sm font-black text-tailor-deep">
                    {{ $profile->max_active_orders ?? '-' }} aktif / {{ $profile->max_weekly_orders ?? '-' }} minggu
                </p>
            </div>
            <div class="rounded-2xl bg-tailor-cream p-4 ring-1 ring-tailor-purple/10">
                <p class="text-xs font-bold text-slate-500">Hari Kerja</p>
                <p class="mt-1 truncate text-sm font-black text-tailor-deep">
                    {{ $selectedWorkingDayLabels->isNotEmpty() ? $selectedWorkingDayLabels->implode(', ') : '-' }}
                </p>
            </div>
        </div>
    </section>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-xl">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-xl">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span class="text-sm font-semibold">Terdapat beberapa kesalahan:</span>
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="tailorProfileForm" action="{{ route('tailor.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Section 1: Personal Info --}}
        <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-tailor-soft rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-tailor-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-slate-800">Informasi Pribadi</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Data akun dan kontak Anda</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                {{-- Profile Photo --}}
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-5">
                    <div class="relative flex-shrink-0">
                        <div id="photo-preview-wrapper" class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-100 border-2 border-slate-200 flex items-center justify-center">
                            @if($profile && $profile->profile_photo)
                                <img id="photo-preview" src="{{ asset('storage/' . $profile->profile_photo) }}"
                                     alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <div id="photo-placeholder" class="flex flex-col items-center justify-center w-full h-full">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <img id="photo-preview" src="" alt="Foto Profil" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        <label for="profile_photo"
                               class="absolute -bottom-2 -right-2 w-8 h-8 brand-gradient text-white rounded-full flex items-center justify-center cursor-pointer shadow-md hover:opacity-90 transition-opacity">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden">
                    </div>
                    <div class="flex-1 pt-1">
                        <p class="text-sm font-semibold text-slate-700">Foto Profil</p>
                        <p class="text-xs text-slate-500 mt-1">JPG, PNG, atau WebP. Maks. 2MB.</p>
                        <p class="text-xs text-slate-400 mt-0.5">Klik ikon kamera untuk mengubah foto.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Name (read only) --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" disabled
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50 text-slate-500 cursor-not-allowed">
                        <p class="text-xs text-slate-400 mt-1">Hubungi admin untuk mengubah nama.</p>
                    </div>

                    {{-- Email (read only) --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                        <input type="text" value="{{ $user->email }}" disabled
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50 text-slate-500 cursor-not-allowed">
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </span>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone', $user->phone ?? '') }}"
                                   placeholder="08xxxxxxxxxx"
                                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('phone') border-red-300 focus:ring-red-500 @enderror">
                        </div>
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Publication Status --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Status Publikasi</label>
                        <div class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-lg bg-slate-50">
                            @if($profile && $profile->is_verified)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Tampil di Publik
                                </span>
                                <span class="text-xs text-slate-500">Profil Anda tampil di pencarian customer.</span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Disembunyikan
                                </span>
                                <span class="text-xs text-slate-500">Profil belum tampil di pencarian customer.</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Status dikelola oleh admin.</p>
                    </div>
                </div>

                {{-- Address --}}
                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Alamat Lengkap
                    </label>
                    <textarea id="address" name="address" rows="3"
                              placeholder="Masukkan alamat lengkap Anda..."
                              class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent resize-none @error('address') border-red-300 focus:ring-red-500 @enderror">{{ old('address', $user->address ?? '') }}</textarea>
                    @error('address')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Shop Profile --}}
        <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 bg-tailor-soft rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-tailor-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-slate-800">Profil Toko</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Informasi toko yang ditampilkan kepada pelanggan</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Shop Name --}}
                    <div>
                        <label for="shop_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Nama Toko <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="shop_name" name="shop_name"
                               value="{{ old('shop_name', $profile->shop_name ?? '') }}"
                               placeholder="Contoh: Tailor Budi Jaya"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('shop_name') border-red-300 focus:ring-red-500 @enderror">
                        @error('shop_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Specialization --}}
                    <div>
                        <label for="specialization" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Spesialisasi
                        </label>
                        <input type="text" id="specialization" name="specialization"
                               value="{{ old('specialization', $profile->specialization ?? '') }}"
                               placeholder="Contoh: Baju Pengantin, Seragam, Jas"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('specialization') border-red-300 focus:ring-red-500 @enderror">
                        @error('specialization')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Experience Years --}}
                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Pengalaman (Tahun)
                        </label>
                        <div class="relative">
                            <input type="number" id="experience_years" name="experience_years" min="0" max="50"
                                   value="{{ old('experience_years', $profile->experience_years ?? '') }}"
                                   placeholder="0"
                                   class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('experience_years') border-red-300 focus:ring-red-500 @enderror">
                            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none">tahun</span>
                        </div>
                        @error('experience_years')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Availability Toggle --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Status Ketersediaan</label>
                        <div class="flex items-center gap-3 px-4 py-2.5 border border-slate-200 rounded-lg bg-slate-50">
                            <button type="button" id="availability-toggle"
                                    onclick="toggleAvailability()"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:ring-offset-1 {{ old('is_available', $profile->is_available ?? true) ? 'bg-tailor-purple' : 'bg-slate-300' }}"
                                    role="switch"
                                    aria-checked="{{ old('is_available', $profile->is_available ?? true) ? 'true' : 'false' }}">
                                <span id="toggle-dot"
                                      class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform {{ old('is_available', $profile->is_available ?? true) ? 'translate-x-6' : 'translate-x-1' }}">
                                </span>
                            </button>
                            <input type="hidden" name="is_available" id="is_available_input"
                                   value="{{ old('is_available', $profile->is_available ?? true) ? '1' : '0' }}">
                            <div>
                                <p id="availability-label" class="text-sm font-medium {{ old('is_available', $profile->is_available ?? true) ? 'text-tailor-purple' : 'text-slate-500' }}">
                                    {{ old('is_available', $profile->is_available ?? true) ? 'Menerima Pesanan' : 'Tidak Menerima Pesanan' }}
                                </p>
                                <p class="text-xs text-slate-400">Tampilkan status di halaman publik</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Deskripsi Toko
                    </label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Ceritakan tentang toko dan layanan Anda kepada calon pelanggan..."
                              class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent resize-none @error('description') border-red-300 focus:ring-red-500 @enderror">{{ old('description', $profile->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1">Jelaskan keunggulan dan jenis layanan yang Anda tawarkan.</p>
                </div>

                {{-- Schedule Capacity --}}
                <div class="border-t border-slate-100 pt-5">
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-slate-800">Jadwal & Kapasitas Pesanan</h3>
                        <p class="text-xs text-slate-500 mt-1">Atur batas antrean agar pelanggan tahu kapasitas toko Anda.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label for="max_active_orders" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Maks. Pesanan Aktif
                            </label>
                            <input type="number" id="max_active_orders" name="max_active_orders" min="1" max="999"
                                   value="{{ old('max_active_orders', $profile->max_active_orders ?? '') }}"
                                   placeholder="Contoh: 10"
                                   class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('max_active_orders') border-red-300 focus:ring-red-500 @enderror">
                            @error('max_active_orders')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_weekly_orders" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Maks. Pesanan / Minggu
                            </label>
                            <input type="number" id="max_weekly_orders" name="max_weekly_orders" min="1" max="999"
                                   value="{{ old('max_weekly_orders', $profile->max_weekly_orders ?? '') }}"
                                   placeholder="Contoh: 5"
                                   class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('max_weekly_orders') border-red-300 focus:ring-red-500 @enderror">
                            @error('max_weekly_orders')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="estimated_processing_days" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Estimasi Pengerjaan
                            </label>
                            <div class="relative">
                                <input type="number" id="estimated_processing_days" name="estimated_processing_days" min="1" max="365"
                                       value="{{ old('estimated_processing_days', $profile->estimated_processing_days ?? '') }}"
                                       placeholder="Contoh: 7"
                                       class="w-full px-4 py-2.5 pr-12 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('estimated_processing_days') border-red-300 focus:ring-red-500 @enderror">
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none">hari</span>
                            </div>
                            @error('estimated_processing_days')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Hari Kerja
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(\App\Models\TailorProfile::WORKING_DAY_LABELS as $day => $label)
                                <label class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-600 hover:border-tailor-purple/30 hover:text-tailor-purple cursor-pointer">
                                    <input type="checkbox"
                                           name="working_days[]"
                                           value="{{ $day }}"
                                           class="rounded border-slate-300 text-tailor-purple focus:ring-tailor-gold"
                                           {{ in_array($day, $selectedWorkingDays, true) ? 'checked' : '' }}>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Deadline pesanan customer harus jatuh pada salah satu hari kerja ini.</p>
                        @error('working_days')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        @error('working_days.*')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Services --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Layanan yang Diterima
                    </label>
                    @php
                        $selectedPriceLists = old('price_list_ids', $user->priceLists->pluck('id')->all());
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 rounded-xl border border-slate-200 p-3">
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
                    <p class="text-xs text-slate-400 mt-1">Customer hanya akan melihat layanan yang Anda pilih saat membuat pesanan.</p>
                    @error('price_list_ids')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    @error('price_list_ids.*')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
            <button type="reset"
                    class="w-full bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors sm:w-auto">
                Reset
            </button>
            <button type="submit"
                    class="brand-gradient text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>

    <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2zm5-7l4 4m0-4l-4 4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-slate-800">Tanggal Tidak Tersedia</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tanggal khusus libur/cuti di luar pola hari kerja mingguan.</p>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('tailor.profile.unavailable-dates.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-5">
                @csrf
                <div class="md:col-span-4">
                    <label for="unavailable_date" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal</label>
                    <input type="date" id="unavailable_date" name="date" min="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('date') border-red-300 focus:ring-red-500 @enderror">
                    @error('date')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-6">
                    <label for="unavailable_reason" class="block text-sm font-medium text-slate-700 mb-1.5">Alasan</label>
                    <input type="text" id="unavailable_reason" name="reason" value="{{ old('reason') }}"
                           placeholder="Contoh: Libur keluarga, workshop tutup"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('reason') border-red-300 focus:ring-red-500 @enderror">
                    @error('reason')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2 flex items-end">
                    <button type="submit" class="w-full brand-gradient text-white px-4 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity">
                        Tambah
                    </button>
                </div>
            </form>

            @if($unavailableDates->isEmpty())
                <div class="rounded-xl bg-slate-50 border border-slate-100 px-4 py-6 text-center">
                    <p class="text-sm text-slate-500">Belum ada tanggal tidak tersedia.</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($unavailableDates as $date)
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-100 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $date->date->format('d M Y') }}</p>
                                <p class="text-xs text-slate-500">{{ $date->reason ?: 'Tanpa alasan' }}</p>
                            </div>
                            <form action="{{ route('tailor.profile.unavailable-dates.destroy', $date) }}" method="POST"
                                  onsubmit="return confirm('Hapus tanggal tidak tersedia ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-semibold hover:bg-red-100">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Profile photo preview
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            const img = document.getElementById('photo-preview');
            const placeholder = document.getElementById('photo-placeholder');
            img.src = ev.target.result;
            img.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    // Availability toggle
    function toggleAvailability() {
        const toggle = document.getElementById('availability-toggle');
        const dot = document.getElementById('toggle-dot');
        const input = document.getElementById('is_available_input');
        const label = document.getElementById('availability-label');

        const isOn = input.value === '1';

        if (isOn) {
            input.value = '0';
            toggle.classList.replace('bg-tailor-purple', 'bg-slate-300');
            dot.classList.replace('translate-x-6', 'translate-x-1');
            toggle.setAttribute('aria-checked', 'false');
            label.textContent = 'Tidak Menerima Pesanan';
            label.classList.replace('text-tailor-purple', 'text-slate-500');
        } else {
            input.value = '1';
            toggle.classList.replace('bg-slate-300', 'bg-tailor-purple');
            dot.classList.replace('translate-x-1', 'translate-x-6');
            toggle.setAttribute('aria-checked', 'true');
            label.textContent = 'Menerima Pesanan';
            label.classList.replace('text-slate-500', 'text-tailor-purple');
        }
    }
</script>
@endpush
