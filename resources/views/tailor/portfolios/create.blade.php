@extends('layouts.app')

@section('title', 'Tambah Portfolio')
@section('page-title', 'Tambah Portfolio')
@section('page-subtitle', 'Unggah karya Anda untuk ditampilkan di profil toko')

@section('sidebar-nav')
    <a href="{{ route('tailor.dashboard') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailor.dashboard*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('tailor.profile.edit') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailor.profile*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        Profil Toko
    </a>
    <a href="{{ route('tailor.portfolios.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailor.portfolios*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Portfolio
    </a>
    <a href="{{ route('tailor.orders.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('tailor.orders*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-slate-800">Informasi Portfolio</h2>
                <p class="text-xs text-slate-500 mt-0.5">Isi detail karya yang ingin Anda tampilkan</p>
            </div>
        </div>

        <form action="{{ route('tailor.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            {{-- Image Upload --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Gambar Portfolio <span class="text-red-500">*</span>
                </label>

                {{-- Drop Zone --}}
                <div id="image-dropzone"
                     onclick="document.getElementById('image').click()"
                     ondragover="handleDragOver(event)"
                     ondragleave="handleDragLeave(event)"
                     ondrop="handleDrop(event)"
                     class="relative border-2 border-dashed border-slate-200 rounded-xl overflow-hidden cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/30 transition-all group">

                    {{-- Preview (hidden by default) --}}
                    <div id="image-preview-container" class="hidden">
                        <img id="image-preview" src="" alt="Preview" class="w-full max-h-72 object-contain bg-slate-50">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg text-xs font-medium text-slate-700 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Ganti Gambar
                            </div>
                        </div>
                    </div>

                    {{-- Placeholder --}}
                    <div id="image-placeholder" class="flex flex-col items-center justify-center py-12 px-6 text-center">
                        <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-indigo-100 transition-colors">
                            <svg class="w-7 h-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-slate-600">Klik atau seret gambar ke sini</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, WebP · Maks. 5MB</p>
                    </div>
                </div>

                <input type="file" id="image" name="image" accept="image/*" class="hidden" required>
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
                       value="{{ old('title') }}"
                       placeholder="Contoh: Kebaya Modern Pengantin 2024"
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('title') border-red-300 focus:ring-red-500 @enderror">
                @error('title')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label for="category" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Kategori
                </label>
                <select id="category" name="category"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('category') border-red-300 focus:ring-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach(['Kebaya', 'Gaun Pengantin', 'Jas & Setelan', 'Seragam', 'Pakaian Kasual', 'Batik', 'Pakaian Anak', 'Lainnya'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Deskripsi
                </label>
                <textarea id="description" name="description" rows="4"
                          placeholder="Ceritakan detail karya ini: bahan yang digunakan, teknik khusus, atau keunikannya..."
                          class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none @error('description') border-red-300 focus:ring-red-500 @enderror">{{ old('description') }}</textarea>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Simpan Portfolio
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

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
            placeholder.classList.add('hidden');
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
            // Transfer to input
            const dt = new DataTransfer();
            dt.items.add(file);
            imageInput.files = dt.files;
            showPreview(file);
        }
    }
</script>
@endpush
