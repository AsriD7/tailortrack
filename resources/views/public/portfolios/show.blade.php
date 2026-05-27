@extends('layouts.customer')

@section('title', $portfolio->title . ' - Portfolio')
@section('meta-description', Str::limit($portfolio->description ?? 'Portfolio karya penjahit di TailorTrack', 160))
@section('fullwidth', true)

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('landing') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('portfolios.index') }}" class="hover:text-indigo-600 transition-colors">Portfolio</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-700 font-medium truncate">{{ $portfolio->title }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Content --}}
        <div class="lg:col-span-2">
            {{-- Image --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
                <div class="aspect-[16/10] overflow-hidden bg-slate-100">
                    @if($portfolio->image)
                        <img src="{{ Storage::url($portfolio->image) }}"
                             alt="{{ $portfolio->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-gradient-to-br from-slate-50 to-slate-100">
                            <svg class="w-20 h-20 mb-2" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Tidak ada foto</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Detail --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    @if($portfolio->category)
                        <span class="inline-flex px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                            {{ $portfolio->category }}
                        </span>
                    @endif
                    @if($portfolio->client_type)
                        <span class="inline-flex px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-semibold">
                            {{ $portfolio->client_type }}
                        </span>
                    @endif
                    @if($portfolio->is_featured)
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-xs font-bold">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Unggulan
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mb-4">{{ $portfolio->title }}</h1>

                @if($portfolio->description)
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed mb-6">
                        {!! nl2br(e($portfolio->description)) !!}
                    </div>
                @endif

                {{-- Meta info --}}
                <div class="flex flex-wrap gap-4 text-sm text-slate-500 pt-4 border-t border-slate-100">
                    @if($portfolio->price_range)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Kisaran: {{ $portfolio->price_range }}
                        </div>
                    @endif
                    @if($portfolio->completed_at)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Selesai: {{ $portfolio->completed_at->translatedFormat('d F Y') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Tailor Card --}}
            @if($portfolio->tailor)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Penjahit</h3>

                <div class="flex items-center gap-3 mb-4">
                    @if($portfolio->tailor->tailorProfile && $portfolio->tailor->tailorProfile->photo)
                        <img src="{{ Storage::url($portfolio->tailor->tailorProfile->photo) }}"
                             alt="{{ $portfolio->tailor->tailorProfile->shop_name }}"
                             class="w-14 h-14 rounded-xl object-cover ring-2 ring-indigo-100">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-lg font-bold ring-2 ring-indigo-100">
                            {{ strtoupper(substr($portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-800 truncate">
                            {{ $portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name }}
                        </h4>
                        <p class="text-sm text-slate-500 truncate">{{ $portfolio->tailor->name }}</p>
                    </div>
                </div>

                @if($portfolio->tailor->tailorProfile && $portfolio->tailor->tailorProfile->specialization)
                    <span class="inline-flex px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold mb-4">
                        {{ $portfolio->tailor->tailorProfile->specialization }}
                    </span>
                @endif

                <a href="{{ route('tailors.show', $portfolio->tailor) }}"
                   class="block w-full text-center btn-primary px-4 py-2.5 rounded-xl text-sm font-semibold">
                    Lihat Profil Penjahit
                </a>
            </div>
            @endif

            {{-- Related Portfolios --}}
            @if($relatedPortfolios->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Karya Lainnya</h3>
                <div class="space-y-3">
                    @foreach($relatedPortfolios as $related)
                    <a href="{{ route('portfolios.show', $related) }}"
                       class="flex items-center gap-3 p-2 -mx-2 rounded-xl hover:bg-slate-50 transition-colors group">
                        <div class="w-16 h-12 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0">
                            @if($related->image)
                                <img src="{{ Storage::url($related->image) }}" alt="{{ $related->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-700 truncate group-hover:text-indigo-600 transition-colors">
                                {{ $related->title }}
                            </p>
                            @if($related->category)
                                <p class="text-xs text-slate-400">{{ $related->category }}</p>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Back button --}}
            <a href="{{ route('portfolios.index') }}"
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Portfolio
            </a>
        </div>

    </div>
</div>

@endsection
