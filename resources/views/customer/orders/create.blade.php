@extends('layouts.customer')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="mb-6 overflow-hidden rounded-[2rem] border border-tailor-purple/10 bg-white shadow-soft">
    <div class="relative brand-gradient px-5 py-6 text-white sm:px-8 sm:py-8">
        <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-[radial-gradient(circle_at_top_right,rgba(240,179,79,0.35),transparent_55%)] sm:block"></div>
        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.24em] text-tailor-gold">Buat Pesanan</p>
                <h1 class="mt-2 text-2xl font-black tracking-tight sm:text-4xl">Detail pesanan jahit</h1>
                <p class="mt-3 max-w-2xl text-sm font-medium leading-7 text-white/80">
                    Pilih layanan, isi ukuran, upload referensi, lalu kirim pesanan ke penjahit untuk diproses.
                </p>
            </div>
            <a href="{{ route('customer.orders.index') }}"
               class="inline-flex items-center justify-center rounded-2xl bg-white/12 px-5 py-3 text-sm font-extrabold text-white ring-1 ring-white/20 transition hover:bg-white/18">
                Kembali
            </a>
        </div>
    </div>
</div>

<form action="{{ route('customer.orders.store') }}" method="POST" enctype="multipart/form-data" id="orderForm">
    @csrf
    <input type="hidden" name="tailor_id" value="{{ $tailor->id }}">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===== LEFT SIDE: Form (2/3) ===== --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-red-700 mb-1">Terdapat kesalahan pada formulir:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm text-red-600">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tailor Info Card (read-only) --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informasi Penjahit
                </h3>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl brand-gradient flex items-center justify-center text-white text-xl font-bold shrink-0">
                        {{ mb_substr($tailor->tailorProfile->shop_name ?? $tailor->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base font-bold text-slate-800 leading-tight">
                            {{ $tailor->tailorProfile->shop_name ?? '-' }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $tailor->name }}</p>
                        @if($tailor->tailorProfile->specialization)
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @foreach(explode(',', $tailor->tailorProfile->specialization) as $spec)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-tailor-soft text-tailor-purple">
                                        {{ trim($spec) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="shrink-0">
                        @if($isAtCapacity)
                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Penuh
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Terpilih
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div class="rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
                        <p class="text-slate-400 font-medium">Antrean Aktif</p>
                        <p class="text-slate-700 font-bold mt-0.5">
                            {{ $activeOrdersCount }}{{ $tailor->tailorProfile?->max_active_orders ? ' / ' . $tailor->tailorProfile->max_active_orders : '' }}
                        </p>
                    </div>
                    <div class="rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
                        <p class="text-slate-400 font-medium">Pesanan Minggu Ini</p>
                        <p class="text-slate-700 font-bold mt-0.5">
                            {{ $weeklyOrdersCount }}{{ $tailor->tailorProfile?->max_weekly_orders ? ' / ' . $tailor->tailorProfile->max_weekly_orders : '' }}
                        </p>
                    </div>
                    <div class="rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
                        <p class="text-slate-400 font-medium">Estimasi</p>
                        <p class="text-slate-700 font-bold mt-0.5">
                            {{ $tailor->tailorProfile?->estimated_processing_days ? $tailor->tailorProfile->estimated_processing_days . ' hari' : 'Dikonfirmasi' }}
                        </p>
                    </div>
                </div>
                @if($workingDayLabels->isNotEmpty())
                    <div class="mt-3 rounded-xl bg-tailor-soft border border-tailor-purple/10 px-4 py-3 text-xs text-tailor-purple">
                        Hari kerja penjahit: <span class="font-semibold">{{ $workingDayLabels->implode(', ') }}</span>
                    </div>
                @endif
                @if($unavailableDates->isNotEmpty())
                    <div class="mt-3 rounded-xl bg-red-50 border border-red-100 px-4 py-3 text-xs text-red-700">
                        <p class="font-semibold mb-1">Tanggal tidak tersedia:</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($unavailableDates as $date)
                                <span class="inline-flex px-2 py-0.5 rounded-full bg-white/70 border border-red-100">
                                    {{ $date->date->format('d M Y') }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($isAtCapacity)
                    <div class="mt-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        Penjahit sedang penuh sesuai batas antrean yang diatur. Silakan pilih penjahit lain atau cek kembali nanti.
                    </div>
                @endif
            </div>

            {{-- Order Detail Form --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6 space-y-5">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                    </svg>
                    Detail Pesanan
                </h3>

                {{-- Price List Selector --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jenis Pakaian / Layanan <span class="text-red-500">*</span>
                    </label>

                    @if($priceLists->isNotEmpty())
                        @php
                            $serviceCategories = $priceLists->pluck('category')->filter()->unique()->values();
                            $selectedPriceListId = old('price_list_id');
                            $selectedPriceList = $selectedPriceListId ? $priceLists->firstWhere('id', (int) $selectedPriceListId) : null;
                            $activeServiceCategory = old('service_category', $selectedPriceList?->category ?? $serviceCategories->first());
                        @endphp

                        <input type="hidden" name="service_category" id="service_category" value="{{ $activeServiceCategory }}">

                        <div class="mb-3">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kategori</p>
                            <div id="serviceCategorySelector" class="flex flex-wrap gap-2">
                                @foreach($serviceCategories as $category)
                                    <button type="button"
                                            data-category="{{ $category }}"
                                            class="service-category-option inline-flex items-center px-3 py-2 rounded-xl border text-xs font-bold transition-colors {{ $activeServiceCategory === $category ? 'border-tailor-purple bg-tailor-soft text-tailor-purple' : 'border-slate-200 bg-white text-slate-600 hover:border-tailor-purple/30 hover:text-tailor-purple hover:bg-tailor-soft' }}">
                                        {{ $category }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div id="priceListSelector" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($priceLists as $priceList)
                            @php $isSelected = old('price_list_id') == $priceList->id; @endphp
                            <label data-category="{{ $priceList->category }}"
                                   class="price-list-option group relative rounded-2xl border-2 p-4 cursor-pointer transition-all {{ $isSelected ? 'border-tailor-purple bg-tailor-soft shadow-sm' : 'border-slate-200 bg-white hover:border-tailor-purple/30 hover:bg-tailor-soft/40' }}">
                                <input
                                    type="radio"
                                    name="price_list_id"
                                    value="{{ $priceList->id }}"
                                    data-price="{{ $priceList->base_price }}"
                                    class="sr-only"
                                    required
                                    {{ $isSelected ? 'checked' : '' }}
                                >
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-bold text-slate-800 text-sm">{{ $priceList->name }}</h4>
                                            <span class="inline-flex px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[11px] font-semibold option-category">
                                                {{ $priceList->category }}
                                            </span>
                                        </div>
                                        @if($priceList->description)
                                            <p class="text-xs text-slate-500 leading-relaxed mt-2 line-clamp-2">
                                                {{ $priceList->description }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <p class="text-sm font-extrabold text-tailor-purple">
                                            Rp {{ number_format($priceList->base_price, 0, ',', '.') }}
                                        </p>
                                        <div class="option-check mt-2 ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center {{ $isSelected ? 'border-tailor-purple bg-tailor-purple' : 'border-slate-300 bg-white' }}">
                                            <svg class="w-3 h-3 text-white {{ $isSelected ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                        </div>

                        <div id="emptyCategoryMessage" class="hidden mt-3 rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 text-xs text-slate-500">
                            Tidak ada layanan pada kategori ini.
                        </div>
                    @else
                        <div class="mt-2 rounded-xl bg-amber-50 border border-amber-200 px-4 py-3 text-xs text-amber-700 leading-relaxed">
                            Penjahit ini belum memilih layanan yang diterima. Silakan hubungi penjahit atau pilih penjahit lain.
                        </div>
                    @endif

                    @error('price_list_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Size Selector --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Ukuran <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-2" id="sizeSelector">
                        @php $sizes = ['S', 'M', 'L', 'XL', 'XXL', 'Custom']; @endphp
                        @foreach($sizes as $size)
                            <label class="size-option">
                                <input type="radio" name="size" value="{{ $size }}"
                                       class="sr-only"
                                       {{ old('size', 'M') === $size ? 'checked' : '' }}>
                                <span class="size-label inline-flex items-center justify-center px-4 py-2 rounded-lg border-2 text-sm font-semibold cursor-pointer transition-all
                                    {{ old('size', 'M') === $size
                                        ? 'border-tailor-purple bg-tailor-soft text-tailor-purple'
                                        : 'border-slate-200 bg-white text-slate-600 hover:border-tailor-purple/30 hover:text-tailor-purple' }}">
                                    {{ $size }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('size')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <div id="standardSizeInfo" class="mt-3 rounded-xl bg-tailor-soft border border-tailor-purple/10 p-4 text-sm text-tailor-deep"></div>

                    <div id="customMeasurementPanel" class="hidden mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <p class="text-sm font-bold text-slate-800">Detail Ukuran Custom</p>
                                <p class="text-xs text-slate-500 mt-0.5">Pilih profil ukuran tersimpan atau isi manual untuk pesanan ini.</p>
                            </div>
                            <a href="{{ route('customer.measurements.create') }}"
                               class="text-xs font-semibold text-tailor-purple hover:text-tailor-purple">
                                Tambah profil ukuran
                            </a>
                        </div>

                        <div>
                            <label for="measurement_id" class="block text-xs font-semibold text-slate-600 mb-1.5">Profil Ukuran</label>
                            <select id="measurement_id" name="measurement_id"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold">
                                <option value="">Isi manual untuk pesanan ini</option>
                                @foreach($measurements as $measurement)
                                    <option value="{{ $measurement->id }}" @selected(old('measurement_id') == $measurement->id)>
                                        {{ $measurement->label }}{{ $measurement->gender ? ' - ' . $measurement->gender : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('measurement_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="manualMeasurementFields" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @php
                                $customFields = [
                                    'custom_height_cm' => ['Tinggi Badan', 'cm'],
                                    'custom_weight_kg' => ['Berat Badan', 'kg'],
                                    'custom_chest_cm' => ['Lingkar Dada', 'cm'],
                                    'custom_waist_cm' => ['Lingkar Pinggang', 'cm'],
                                    'custom_hip_cm' => ['Lingkar Pinggul', 'cm'],
                                    'custom_shoulder_cm' => ['Lebar Bahu', 'cm'],
                                    'custom_sleeve_length_cm' => ['Panjang Lengan', 'cm'],
                                    'custom_shirt_length_cm' => ['Panjang Baju', 'cm'],
                                    'custom_pants_length_cm' => ['Panjang Celana/Rok', 'cm'],
                                    'custom_thigh_cm' => ['Lingkar Paha', 'cm'],
                                ];
                            @endphp

                            @foreach($customFields as $field => [$label, $unit])
                                <div>
                                    <label for="{{ $field }}" class="block text-xs font-semibold text-slate-600 mb-1">{{ $label }}</label>
                                    <div class="relative">
                                        <input type="number" step="0.1" min="1" max="300" id="{{ $field }}" name="{{ $field }}"
                                               value="{{ old($field) }}"
                                               class="w-full px-3 py-2 pr-10 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold @error($field) border-red-400 @enderror">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[11px] font-semibold text-slate-400">{{ $unit }}</span>
                                    </div>
                                    @error($field)
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="sm:col-span-2 lg:col-span-3">
                                <label for="custom_measurement_notes" class="block text-xs font-semibold text-slate-600 mb-1">Catatan Ukuran Custom</label>
                                <textarea id="custom_measurement_notes" name="custom_measurement_notes" rows="2" maxlength="500"
                                          placeholder="Contoh: bagian pinggang dibuat longgar, lengan jangan terlalu ketat..."
                                          class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold resize-none @error('custom_measurement_notes') border-red-400 @enderror">{{ old('custom_measurement_notes') }}</textarea>
                                @error('custom_measurement_notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quantity --}}
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <button type="button" id="qtyMinus"
                                class="w-9 h-9 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 font-bold transition-colors">
                            &minus;
                        </button>
                        <input type="number" id="quantity" name="quantity"
                               value="{{ old('quantity', 1) }}" min="1" max="99"
                               class="w-20 text-center px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('quantity') border-red-400 @enderror"
                               required>
                        <button type="button" id="qtyPlus"
                                class="w-9 h-9 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 font-bold transition-colors">
                            +
                        </button>
                    </div>
                    @error('quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Deskripsi Pesanan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                              placeholder="Contoh: Kemeja batik lengan panjang, bahan katun, warna navy..."
                              class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deadline --}}
                <div>
                    <label for="deadline" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Batas Waktu (Deadline)
                    </label>
                    <input type="date" id="deadline" name="deadline"
                           value="{{ old('deadline') }}"
                           min="{{ $minDeadline }}"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent @error('deadline') border-red-400 @enderror">
                    <p class="text-xs text-slate-400 mt-1">
                        Deadline minimal {{ \Illuminate\Support\Carbon::parse($minDeadline)->format('d M Y') }}{{ $workingDayLabels->isNotEmpty() ? ' dan harus jatuh pada hari kerja penjahit.' : '.' }}
                    </p>
                    @error('deadline')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Note --}}
                <div>
                    <label for="note" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Catatan Tambahan
                    </label>
                    <textarea id="note" name="note" rows="2"
                              placeholder="Catatan khusus untuk penjahit (opsional)..."
                              class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent resize-none @error('note') border-red-400 @enderror">{{ old('note') }}</textarea>
                    @error('note')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Reference Images Upload --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Referensi Desain
                    <span id="imageCounter" class="ml-auto text-xs font-normal text-slate-400 normal-case">Maks. 5 foto</span>
                </h3>

                {{-- Drop Zone --}}
                <label for="images"
                       class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer bg-slate-50 hover:bg-tailor-soft hover:border-tailor-purple/40 transition-colors group">
                    <div class="flex flex-col items-center gap-2 text-center px-4">
                        <svg class="w-8 h-8 text-slate-400 group-hover:text-tailor-purple transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-slate-600 group-hover:text-tailor-purple">Klik untuk unggah referensi desain</p>
                            <p class="text-xs text-slate-400 mt-0.5">PNG, JPG, JPEG, WEBP - maks. 2MB per foto</p>
                        </div>
                    </div>
                    <input type="file" id="images" name="images[]"
                           class="hidden" multiple accept="image/png,image/jpeg,image/jpg,image/webp">
                </label>

                @error('images')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <p class="text-xs text-slate-500 mt-3">
                    Gunakan foto contoh model, warna, potongan, atau detail jahitan agar penjahit lebih mudah memahami pesanan.
                </p>

                {{-- Image Previews --}}
                <div id="imagePreviewGrid" class="grid grid-cols-3 sm:grid-cols-5 gap-3 mt-4 hidden"></div>
            </div>

            {{-- Submit Button --}}
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('customer.orders.index') }}"
                   class="bg-slate-100 text-slate-700 px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 brand-gradient text-white px-8 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ $priceLists->isEmpty() || $isAtCapacity ? 'disabled' : '' }}>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Buat Pesanan
                </button>
            </div>

        </div>{{-- end left --}}

        {{-- ===== RIGHT SIDE: Price Estimator (1/3) ===== --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Price Estimator Card --}}
            <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-6 sticky top-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Estimasi Harga
                </h3>

                {{-- Price Breakdown --}}
                <div class="space-y-3 mb-5">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Harga Dasar</span>
                        <span id="est-base-price" class="font-semibold text-slate-800">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Surcharge Ukuran</span>
                        <span id="est-surcharge" class="font-semibold text-slate-800">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Jumlah</span>
                        <span id="est-qty" class="font-semibold text-slate-800">×1</span>
                    </div>
                    <div class="border-t border-slate-100 pt-3 flex justify-between items-center">
                        <span class="text-sm font-semibold text-slate-700">Total Estimasi</span>
                        <span id="est-total" class="text-lg font-bold text-tailor-purple">Rp 0</span>
                    </div>
                </div>

                {{-- Note --}}
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 mb-5">
                    <p class="text-xs text-amber-700 leading-relaxed">
                        <span class="font-semibold">Catatan:</span> Ini adalah estimasi awal. Harga final akan dikonfirmasi oleh penjahit setelah pesanan dibuat.
                    </p>
                </div>

                {{-- Size Surcharge Table --}}
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Tabel Surcharge Ukuran</p>
                    <div class="rounded-xl overflow-hidden border border-slate-100">
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="px-3 py-2 text-left font-semibold text-slate-500">Ukuran</th>
                                    <th class="px-3 py-2 text-right font-semibold text-slate-500">Tambahan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr>
                                    <td class="px-3 py-2 text-slate-700">S, M</td>
                                    <td class="px-3 py-2 text-right font-medium text-slate-600">Rp 0</td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 text-slate-700">L</td>
                                    <td class="px-3 py-2 text-right font-medium text-tailor-purple">+ Rp 5.000</td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 text-slate-700">XL</td>
                                    <td class="px-3 py-2 text-right font-medium text-tailor-purple">+ Rp 10.000</td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 text-slate-700">XXL</td>
                                    <td class="px-3 py-2 text-right font-medium text-tailor-purple">+ Rp 15.000</td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 text-slate-700">Custom</td>
                                    <td class="px-3 py-2 text-right font-medium text-tailor-purple">+ Rp 20.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>{{-- end right --}}

    </div>
</form>
@endsection

{{-- ======================== SCRIPTS ======================== --}}
@push('scripts')
<script>
(function () {
    // Size surcharges
    const SURCHARGES = { S: 0, M: 0, L: 5000, XL: 10000, XXL: 15000, Custom: 20000 };
    const STANDARD_SIZE_DETAILS = @json($standardSizeDetails);

    // DOM refs
    const quantityInput   = document.getElementById('quantity');
    const qtyMinus        = document.getElementById('qtyMinus');
    const qtyPlus         = document.getElementById('qtyPlus');
    const imagesInput     = document.getElementById('images');
    const previewGrid     = document.getElementById('imagePreviewGrid');
    const imageCounter    = document.getElementById('imageCounter');
    const serviceCategoryInput = document.getElementById('service_category');
    const emptyCategoryMessage = document.getElementById('emptyCategoryMessage');
    const standardSizeInfo = document.getElementById('standardSizeInfo');
    const customMeasurementPanel = document.getElementById('customMeasurementPanel');
    const measurementSelect = document.getElementById('measurement_id');
    const manualMeasurementFields = document.getElementById('manualMeasurementFields');

    const estBase    = document.getElementById('est-base-price');
    const estSurge   = document.getElementById('est-surcharge');
    const estQty     = document.getElementById('est-qty');
    const estTotal   = document.getElementById('est-total');

    // Format currency
    function rupiah(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    // Get selected size
    function getSelectedSize() {
        const checked = document.querySelector('input[name="size"]:checked');
        return checked ? checked.value : 'M';
    }

    function getSelectedPriceList() {
        return document.querySelector('input[name="price_list_id"]:checked');
    }

    // Update estimate display
    function updateEstimate() {
        const selectedPriceList = getSelectedPriceList();
        const basePrice  = parseInt(selectedPriceList?.dataset?.price || 0, 10);
        const size       = getSelectedSize();
        const surcharge  = SURCHARGES[size] ?? 0;
        const qty        = Math.max(1, parseInt(quantityInput.value, 10) || 1);
        const total      = (basePrice + surcharge) * qty;

        estBase.textContent  = rupiah(basePrice);
        estSurge.textContent = surcharge > 0 ? ('+ ' + rupiah(surcharge)) : rupiah(0);
        estQty.textContent   = 'x' + qty;
        estTotal.textContent = rupiah(total);
    }

    function updatePriceListStyles() {
        document.querySelectorAll('.price-list-option').forEach(function (label) {
            const radio = label.querySelector('input[type="radio"]');
            const check = label.querySelector('.option-check');
            const checkIcon = check ? check.querySelector('svg') : null;

            if (radio.checked) {
                label.classList.remove('border-slate-200', 'bg-white', 'hover:border-tailor-purple/30', 'hover:bg-tailor-soft/40');
                label.classList.add('border-tailor-purple', 'bg-tailor-soft', 'shadow-sm');
                if (check) {
                    check.classList.remove('border-slate-300', 'bg-white');
                    check.classList.add('border-tailor-purple', 'bg-tailor-purple');
                }
                if (checkIcon) checkIcon.classList.remove('hidden');
            } else {
                label.classList.remove('border-tailor-purple', 'bg-tailor-soft', 'shadow-sm');
                label.classList.add('border-slate-200', 'bg-white', 'hover:border-tailor-purple/30', 'hover:bg-tailor-soft/40');
                if (check) {
                    check.classList.remove('border-tailor-purple', 'bg-tailor-purple');
                    check.classList.add('border-slate-300', 'bg-white');
                }
                if (checkIcon) checkIcon.classList.add('hidden');
            }
        });
    }

    // Size radio button styling
    function getActiveServiceCategory() {
        return serviceCategoryInput ? serviceCategoryInput.value : '';
    }

    function updateServiceCategoryStyles() {
        const activeCategory = getActiveServiceCategory();

        document.querySelectorAll('.service-category-option').forEach(function (button) {
            if (button.dataset.category === activeCategory) {
                button.classList.remove('border-slate-200', 'bg-white', 'text-slate-600', 'hover:border-tailor-purple/30', 'hover:text-tailor-purple', 'hover:bg-tailor-soft');
                button.classList.add('border-tailor-purple', 'bg-tailor-soft', 'text-tailor-purple');
            } else {
                button.classList.remove('border-tailor-purple', 'bg-tailor-soft', 'text-tailor-purple');
                button.classList.add('border-slate-200', 'bg-white', 'text-slate-600', 'hover:border-tailor-purple/30', 'hover:text-tailor-purple', 'hover:bg-tailor-soft');
            }
        });
    }

    function updateVisibleServices() {
        const activeCategory = getActiveServiceCategory();
        let visibleCount = 0;

        document.querySelectorAll('.price-list-option').forEach(function (label) {
            const radio = label.querySelector('input[type="radio"]');
            const isVisible = !activeCategory || label.dataset.category === activeCategory;

            label.classList.toggle('hidden', !isVisible);
            if (radio) radio.disabled = !isVisible;

            if (isVisible) visibleCount++;
        });

        if (emptyCategoryMessage) {
            emptyCategoryMessage.classList.toggle('hidden', visibleCount > 0);
        }
    }

    function updateSizeStyles() {
        document.querySelectorAll('.size-option').forEach(function (label) {
            const radio = label.querySelector('input[type="radio"]');
            const span  = label.querySelector('.size-label');
            if (radio.checked) {
                span.classList.remove('border-slate-200', 'bg-white', 'text-slate-600', 'hover:border-tailor-purple/30', 'hover:text-tailor-purple');
                span.classList.add('border-tailor-purple', 'bg-tailor-soft', 'text-tailor-purple');
            } else {
                span.classList.remove('border-tailor-purple', 'bg-tailor-soft', 'text-tailor-purple');
                span.classList.add('border-slate-200', 'bg-white', 'text-slate-600', 'hover:border-tailor-purple/30', 'hover:text-tailor-purple');
            }
        });
    }

    function updateMeasurementUi() {
        const size = getSelectedSize();
        const isCustom = size === 'Custom';

        if (customMeasurementPanel) {
            customMeasurementPanel.classList.toggle('hidden', !isCustom);
        }

        if (standardSizeInfo) {
            if (isCustom) {
                standardSizeInfo.classList.add('hidden');
            } else {
                const details = STANDARD_SIZE_DETAILS[size] || {};
                const rows = Object.entries(details)
                    .map(function ([label, value]) {
                        return '<div class="rounded-lg bg-white/70 border border-tailor-purple/10 px-3 py-2"><p class="text-[11px] text-tailor-purple font-semibold">' + label + '</p><p class="text-sm font-bold text-tailor-deep">' + value + '</p></div>';
                    })
                    .join('');

                standardSizeInfo.innerHTML = '<p class="font-bold mb-2">Acuan ukuran standar ' + size + '</p><div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">' + rows + '</div><p class="text-xs text-tailor-purple mt-2">Acuan ini membantu penjahit membaca ukuran standar. Untuk ukuran badan detail, pilih Custom.</p>';
                standardSizeInfo.classList.remove('hidden');
            }
        }

        if (manualMeasurementFields && measurementSelect) {
            manualMeasurementFields.classList.toggle('opacity-50', Boolean(measurementSelect.value));
        }
    }

    // Quantity stepper
    qtyMinus.addEventListener('click', function () {
        const v = parseInt(quantityInput.value, 10);
        if (v > 1) { quantityInput.value = v - 1; updateEstimate(); }
    });
    qtyPlus.addEventListener('click', function () {
        const v = parseInt(quantityInput.value, 10);
        if (v < 99) { quantityInput.value = v + 1; updateEstimate(); }
    });

    // Event listeners
    document.querySelectorAll('.service-category-option').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!serviceCategoryInput) return;

            serviceCategoryInput.value = button.dataset.category;

            const selectedService = getSelectedPriceList();
            if (selectedService && selectedService.closest('.price-list-option')?.dataset.category !== button.dataset.category) {
                selectedService.checked = false;
            }

            updateServiceCategoryStyles();
            updateVisibleServices();
            updatePriceListStyles();
            updateEstimate();
        });
    });

    document.querySelectorAll('input[name="price_list_id"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            updatePriceListStyles();
            updateEstimate();
        });
    });
    quantityInput.addEventListener('input', updateEstimate);

    document.querySelectorAll('input[name="size"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            updateSizeStyles();
            updateMeasurementUi();
            updateEstimate();
        });
    });

    if (measurementSelect) {
        measurementSelect.addEventListener('change', updateMeasurementUi);
    }

    // Image preview
    imagesInput.addEventListener('change', function () {
        previewGrid.innerHTML = '';
        const files = Array.from(this.files).slice(0, 5);
        const dataTransfer = new DataTransfer();
        files.forEach(function (file) {
            dataTransfer.items.add(file);
        });
        this.files = dataTransfer.files;

        if (imageCounter) {
            imageCounter.textContent = files.length > 0 ? files.length + ' / 5 foto' : 'Maks. 5 foto';
        }

        if (files.length === 0) {
            previewGrid.classList.add('hidden');
            return;
        }

        previewGrid.classList.remove('hidden');

        files.forEach(function (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative group aspect-square rounded-xl overflow-hidden border border-slate-200';

                const img = document.createElement('img');
                img.src       = e.target.result;
                img.className = 'w-full h-full object-cover';
                img.alt       = file.name;

                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center';
                overlay.innerHTML = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';

                wrapper.appendChild(img);
                wrapper.appendChild(overlay);
                previewGrid.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    });

    // Init
    updateServiceCategoryStyles();
    updateVisibleServices();
    updatePriceListStyles();
    updateSizeStyles();
    updateMeasurementUi();
    updateEstimate();
})();
</script>
@endpush
