@extends('layouts.customer')

@section('title', 'Portfolio Karya Penjahit')
@section('meta-description', 'Lihat portfolio dan hasil karya terbaik dari penjahit-penjahit profesional di TailorTrack.')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mb-1">
                <span class="gradient-text">Portfolio</span> Karya Penjahit
            </h1>
            <p class="text-slate-500 text-sm sm:text-base">Lihat hasil karya terbaik dari penjahit-penjahit profesional kami.</p>
        </div>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('portfolios.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari judul, deskripsi, atau nama penjahit..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none transition-all bg-white">
        </div>

        <select name="category" onchange="this.form.submit()"
                class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 outline-none bg-white cursor-pointer">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn-primary px-5 py-2.5 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Cari
        </button>
    </form>
</div>

{{-- Active Filters --}}
@if(request('search') || request('category'))
<div class="flex flex-wrap items-center gap-2 mb-6">
    <span class="text-sm text-slate-500">Filter aktif:</span>
    @if(request('search'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-medium">
            "{{ request('search') }}"
            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="hover:text-indigo-900">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            </a>
        </span>
    @endif
    @if(request('category'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-medium">
            {{ request('category') }}
            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="hover:text-purple-900">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
            </a>
        </span>
    @endif
    <a href="{{ route('portfolios.index') }}" class="text-xs text-slate-400 hover:text-red-500 transition-colors ml-1">Reset semua</a>
</div>
@endif

{{-- Portfolio Grid --}}
@if($portfolios->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($portfolios as $portfolio)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden card-hover group">
            {{-- Portfolio Image --}}
            <div class="aspect-[4/3] overflow-hidden bg-slate-100 relative">
                @if($portfolio->image)
                    <img src="{{ Storage::url($portfolio->image) }}"
                         alt="{{ $portfolio->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-gradient-to-br from-slate-50 to-slate-100">
                        <svg class="w-12 h-12 mb-1" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs">Tidak ada foto</span>
                    </div>
                @endif

                {{-- Category badge --}}
                @if($portfolio->category)
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex px-2.5 py-1 rounded-full bg-black/50 backdrop-blur-sm text-white text-xs font-semibold">
                            {{ $portfolio->category }}
                        </span>
                    </div>
                @endif

                {{-- Featured badge --}}
                @if($portfolio->is_featured)
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-yellow-400/90 backdrop-blur-sm text-yellow-900 text-xs font-bold">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Unggulan
                        </span>
                    </div>
                @endif

                {{-- Hover overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                    <a href="{{ route('portfolios.show', $portfolio) }}"
                       class="inline-flex items-center gap-1.5 text-white text-sm font-semibold hover:underline">
                        Lihat Detail
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Info --}}
            <div class="p-4">
                <a href="{{ route('portfolios.show', $portfolio) }}">
                    <h3 class="font-bold text-slate-800 mb-1 line-clamp-1 group-hover:text-indigo-600 transition-colors">
                        {{ $portfolio->title }}
                    </h3>
                </a>
                @if($portfolio->description)
                    <p class="text-slate-500 text-sm line-clamp-2 mb-3">{{ $portfolio->description }}</p>
                @endif

                {{-- Tailor info --}}
                @if($portfolio->tailor)
                    <div class="flex items-center gap-2 pt-3 border-t border-slate-50">
                        @if($portfolio->tailor->tailorProfile && $portfolio->tailor->tailorProfile->photo)
                            <img src="{{ Storage::url($portfolio->tailor->tailorProfile->photo) }}"
                                 alt="{{ $portfolio->tailor->tailorProfile->shop_name }}"
                                 class="w-6 h-6 rounded-full object-cover ring-1 ring-slate-200">
                        @else
                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-[10px] font-bold ring-1 ring-slate-200">
                                {{ strtoupper(substr($portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name, 0, 1)) }}
                            </div>
                        @endif
                        <a href="{{ route('tailors.show', $portfolio->tailor) }}"
                           class="text-xs text-slate-500 hover:text-indigo-600 transition-colors font-medium truncate">
                            {{ $portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $portfolios->links() }}
    </div>
@else
    <div class="text-center py-20">
        <div class="w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-600 mb-1">Belum ada portfolio</h3>
        <p class="text-slate-400 text-sm">Portfolio dari penjahit akan muncul di sini.</p>
    </div>
@endif

@endsection
