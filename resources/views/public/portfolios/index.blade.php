@extends('layouts.customer')

@section('title', 'Portfolio Karya Penjahit')
@section('meta-description', 'Lihat portfolio dan hasil karya terbaik dari penjahit profesional di TailorTrack.')
@section('fullwidth', true)

@section('content')
<section class="bg-tailor-cream">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <nav class="mb-8 flex items-center gap-2 text-sm font-semibold text-slate-500">
            <a href="{{ route('landing') }}" class="hover:text-tailor-purple">Beranda</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-tailor-purple">Portfolio</span>
        </nav>

        <div class="grid gap-8 lg:grid-cols-[1fr_0.62fr] lg:items-end">
            <div>
                <span class="inline-flex rounded-full bg-white px-4 py-2 text-sm font-extrabold text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                    Inspirasi jahitan
                </span>
                <h1 class="mt-5 max-w-3xl text-4xl font-black leading-tight text-tailor-deep sm:text-5xl">
                    Lihat hasil karya penjahit sebelum mulai pesan.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600">
                    Gunakan portfolio untuk membandingkan gaya, detail finishing, dan jenis layanan yang sesuai dengan kebutuhan kamu.
                </p>
            </div>
            <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-tailor-purple/10">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-tailor-purple/55">Total Karya</p>
                <p class="mt-2 text-4xl font-black text-tailor-deep">{{ $portfolios->total() }}</p>
                <p class="mt-2 text-sm font-semibold text-slate-500">Portfolio tersedia di TailorTrack</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-8">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('portfolios.index') }}" class="rounded-3xl border border-tailor-purple/10 bg-white p-4 shadow-soft sm:p-5">
            <div class="grid gap-3 md:grid-cols-[1fr_260px_auto]">
                <label class="relative">
                    <span class="sr-only">Cari portfolio</span>
                    <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-tailor-purple/45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, deskripsi, atau nama penjahit..." class="h-12 w-full rounded-2xl border border-tailor-purple/10 bg-tailor-cream pl-12 pr-4 text-sm font-semibold text-tailor-ink outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20">
                </label>

                <select name="category" class="h-12 rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-4 text-sm font-semibold text-tailor-ink outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <button type="submit" class="rounded-2xl brand-gradient px-6 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5">
                    Cari
                </button>
            </div>

            @if(request('search') || request('category'))
                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <span class="text-sm font-semibold text-slate-500">Filter aktif:</span>
                    @if(request('search'))
                        <span class="rounded-full bg-tailor-soft px-3 py-1 text-xs font-black text-tailor-purple">{{ request('search') }}</span>
                    @endif
                    @if(request('category'))
                        <span class="rounded-full bg-tailor-soft px-3 py-1 text-xs font-black text-tailor-purple">{{ request('category') }}</span>
                    @endif
                    <a href="{{ route('portfolios.index') }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-500 hover:bg-slate-200">Reset</a>
                </div>
            @endif
        </form>
    </div>
</section>

<section class="bg-white pb-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if($portfolios->isNotEmpty())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($portfolios as $portfolio)
                    <a href="{{ route('portfolios.show', $portfolio) }}" class="group overflow-hidden rounded-3xl border border-tailor-purple/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="relative aspect-[4/3] overflow-hidden bg-tailor-soft">
                            @if($portfolio->image)
                                <img src="{{ Storage::url($portfolio->image) }}" alt="{{ $portfolio->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="grid h-full w-full place-items-center text-tailor-purple/35">
                                    <svg class="h-14 w-14" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4-4 3 3 5-6 4 5M4 6h16v12H4V6z"/>
                                    </svg>
                                </div>
                            @endif

                            <div class="absolute left-3 top-3 flex flex-wrap gap-2">
                                @if($portfolio->category)
                                    <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-black text-tailor-purple shadow-sm">{{ $portfolio->category }}</span>
                                @endif
                                @if($portfolio->is_featured)
                                    <span class="rounded-full bg-tailor-gold px-3 py-1 text-xs font-black text-tailor-deep shadow-sm">Unggulan</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="line-clamp-1 text-lg font-black text-tailor-deep">{{ $portfolio->title }}</h3>
                            @if($portfolio->description)
                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">{{ $portfolio->description }}</p>
                            @endif

                            @if($portfolio->tailor)
                                <div class="mt-5 flex items-center gap-3 border-t border-tailor-purple/10 pt-4">
                                    @if($portfolio->tailor->tailorProfile && $portfolio->tailor->tailorProfile->photo)
                                        <img src="{{ Storage::url($portfolio->tailor->tailorProfile->photo) }}" alt="{{ $portfolio->tailor->tailorProfile->shop_name }}" class="h-9 w-9 rounded-xl object-cover ring-2 ring-tailor-soft">
                                    @else
                                        <div class="grid h-9 w-9 place-items-center rounded-xl brand-gradient text-xs font-black text-white">
                                            {{ strtoupper(substr($portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-black text-tailor-deep">{{ $portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name }}</p>
                                        <p class="text-xs font-semibold text-slate-400">Penjahit</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            @if($portfolios->hasPages())
                <div class="mt-10 flex justify-center">
                    <div class="rounded-3xl border border-tailor-purple/10 bg-white p-3 shadow-sm">
                        {{ $portfolios->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="rounded-3xl border border-dashed border-tailor-purple/20 bg-tailor-cream p-10 text-center sm:p-14">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-white text-tailor-purple shadow-sm">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4-4 3 3 5-6 4 5M4 6h16v12H4V6z"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-black text-tailor-deep">Belum ada portfolio</h2>
                <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-500">Portfolio dari penjahit akan muncul di sini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
