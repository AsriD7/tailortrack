@extends('layouts.app')

@section('title', 'Edit Portfolio')
@section('page-title', 'Edit Portfolio')
@section('page-subtitle', 'Perbarui informasi dan gambar portfolio Anda')

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
<div class="max-w-2xl mx-auto">

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-xl mb-6">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span class="text-sm font-semibold">Mohon perbaiki kesalahan berikut:</span>
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-slate-800">Edit Portfolio</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui data portfolio "{{ $portfolio->title }}"</p>
            </div>
        </div>

        <form action="{{ route('tailor.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Image Section --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Gambar Portfolio</label>

                {{-- Current Image --}}
                @if($portfolio->image)
                    <div class="mb-3">
                        <p class="text-xs text-slate-500 mb-2 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Gambar saat ini:
                        </p>
                        <div class="relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50" id="current-image-wrapper">
                            <img src="{{ asset('storage/' . $portfolio->image) }}"
                                 alt="{{ $portfolio->title }}"
                                 id="current-image"
                                 class="w-full max-h-56 object-contain">
                            <div class="absolute bottom-2 right-2">
                                <span class="inline-flex items-center gap-1 bg-slate-800/70 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-lg">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Gambar saat ini
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- New Image Upload --}}
                <div id="image-dropzone"
                     onclick="document.getElementById('image').click()"
                     ondragover="handleDragOver(event)"
                     ondragleave="handleDragLeave(event)"
                     ondrop="handleDrop(event)"
                     class="relative border-2 border-dashed border-slate-200 rounded-xl overflow-hidden cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/30 transition-all group">

                    {{-- New Preview (hidden) --}}
                    <div id="image-preview-container" class="hidden">
                        <img id="image-preview" src="" alt="Preview Baru" class="w-full max-h-56 object-contain bg-slate-50">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg text-xs font-medium text-slate-700 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Ganti Gambar
                            </div>
                        </div>
                        <div class="absolute top-2 left-2">
                            <span class="inline-flex items-center gap-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded-lg">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Gambar baru dipilih
                            </span>
                        </div>
                    </div>

                    <div id="image-placeholder" class="flex flex-col items-center justify-center py-8 px-6 text-center">
                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center mb-2 group-hover:bg-indigo-100 transition-colors">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-slate-600">Klik atau seret untuk ganti gambar</p>
                        <p class="text-xs text-slate-400 mt-0.5">Biarkan kosong jika tidak ingin mengganti · Maks. 5MB</p>
                    </div>
                </div>

                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                @error('image')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Judul Portfolio <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title"
                       value="{{ old('title', $portfolio->title) }}"
                       placeholder="Contoh: Kebaya Modern Pengantin 2024"
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('title') border-red-300 focus:ring-red-500 @enderror">
                @error('title')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label for="category" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>
                <select id="category" name="category"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('category') border-red-300 focus:ring-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categoryOptions as $cat)
                        <option value="{{ $cat }}" {{ old('category', $portfolio->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="client_type" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Tipe Proyek
                    </label>
                    <select id="client_type" name="client_type"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('client_type') border-red-300 focus:ring-red-500 @enderror">
                        <option value="">-- Pilih Tipe --</option>
                        @foreach($clientTypeOptions as $type)
                            <option value="{{ $type }}" {{ old('client_type', $portfolio->client_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('client_type')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price_range" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kisaran Harga
                    </label>
                    <input type="text" id="price_range" name="price_range"
                           value="{{ old('price_range', $portfolio->price_range) }}"
                           placeholder="Contoh: Rp 250.000 - Rp 500.000"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('price_range') border-red-300 focus:ring-red-500 @enderror">
                    @error('price_range')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="completed_at" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Tanggal Selesai
                    </label>
                    <input type="date" id="completed_at" name="completed_at"
                           value="{{ old('completed_at', $portfolio->completed_at?->format('Y-m-d')) }}"
                           max="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('completed_at') border-red-300 focus:ring-red-500 @enderror">
                    @error('completed_at')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 bg-slate-50">
                    <input type="checkbox" name="is_featured" value="1"
                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                           {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}>
                    <span>
                        <span class="block text-sm font-semibold text-slate-700">Jadikan karya unggulan</span>
                        <span class="block text-xs text-slate-500 mt-0.5">Ditampilkan lebih dulu di profil publik.</span>
                    </span>
                </label>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                          placeholder="Ceritakan detail karya ini: bahan yang digunakan, teknik khusus, atau keunikannya..."
                          class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none @error('description') border-red-300 focus:ring-red-500 @enderror">{{ old('description', $portfolio->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <a href="{{ route('tailor.portfolios.index') }}"
                   class="bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg font-semibold text-sm hover:bg-slate-200 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <button type="submit"
                        class="gradient-brand text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-opacity flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('image-preview');
    const previewContainer = document.getElementById('image-preview-container');
    const placeholder = document.getElementById('image-placeholder');
    const currentImageWrapper = document.getElementById('current-image-wrapper');

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
            placeholder.classList.add('hidden');
            // Dim the current image to indicate it will be replaced
            if (currentImageWrapper) {
                currentImageWrapper.style.opacity = '0.5';
                const currentImg = document.getElementById('current-image');
                if (currentImg) currentImg.style.filter = 'grayscale(1)';
            }
        };
        reader.readAsDataURL(file);
    }

    imageInput.addEventListener('change', (e) => {
        showPreview(e.target.files[0]);
    });

    function handleDragOver(e) {
        e.preventDefault();
        document.getElementById('image-dropzone').classList.add('border-indigo-500', 'bg-indigo-50/50');
    }

    function handleDragLeave(e) {
        document.getElementById('image-dropzone').classList.remove('border-indigo-500', 'bg-indigo-50/50');
    }

    function handleDrop(e) {
        e.preventDefault();
        document.getElementById('image-dropzone').classList.remove('border-indigo-500', 'bg-indigo-50/50');
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            imageInput.files = dt.files;
            showPreview(file);
        }
    }
</script>
@endpush
