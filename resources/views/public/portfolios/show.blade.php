@extends('layouts.customer')

@section('title', $portfolio->title . ' - Portfolio')
@section('meta-description', Str::limit($portfolio->description ?? 'Portfolio karya penjahit di TailorTrack', 160))
@section('fullwidth', true)

@section('content')
<section class="bg-tailor-cream">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm font-semibold text-slate-500">
            <a href="{{ route('landing') }}" class="hover:text-tailor-purple">Beranda</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('portfolios.index') }}" class="hover:text-tailor-purple">Portfolio</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="truncate text-tailor-purple">{{ $portfolio->title }}</span>
        </nav>
    </div>
</section>

<section class="bg-white py-10">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_360px] lg:px-8">
        <div class="min-w-0">
            <div class="overflow-hidden rounded-[2rem] border border-tailor-purple/10 bg-tailor-soft shadow-soft">
                <div class="aspect-[16/10]">
                    @if($portfolio->image)
                        <img src="{{ Storage::url($portfolio->image) }}" alt="{{ $portfolio->title }}" class="h-full w-full object-cover">
                    @else
                        <div class="grid h-full w-full place-items-center text-tailor-purple/35">
                            <svg class="h-20 w-20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4-4 3 3 5-6 4 5M4 6h16v12H4V6z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 rounded-3xl border border-tailor-purple/10 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex flex-wrap gap-2">
                    @if($portfolio->category)
                        <span class="rounded-full bg-tailor-soft px-3 py-1 text-xs font-black text-tailor-purple">{{ $portfolio->category }}</span>
                    @endif
                    @if($portfolio->client_type)
                        <span class="rounded-full bg-tailor-soft px-3 py-1 text-xs font-black text-tailor-purple">{{ $portfolio->client_type }}</span>
                    @endif
                    @if($portfolio->is_featured)
                        <span class="rounded-full bg-tailor-gold px-3 py-1 text-xs font-black text-tailor-deep">Unggulan</span>
                    @endif
                </div>

                <h1 class="mt-5 text-3xl font-black leading-tight text-tailor-deep sm:text-4xl">{{ $portfolio->title }}</h1>

                @if($portfolio->description)
                    <div class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 sm:text-base">{{ $portfolio->description }}</div>
                @endif

                <div class="mt-6 grid gap-3 border-t border-tailor-purple/10 pt-6 sm:grid-cols-2">
                    @if($portfolio->price_range)
                        <div class="rounded-2xl bg-tailor-cream p-4">
                            <p class="text-xs font-bold text-slate-400">Kisaran Harga</p>
                            <p class="mt-1 font-black text-tailor-deep">{{ $portfolio->price_range }}</p>
                        </div>
                    @endif
                    @if($portfolio->completed_at)
                        <div class="rounded-2xl bg-tailor-cream p-4">
                            <p class="text-xs font-bold text-slate-400">Selesai</p>
                            <p class="mt-1 font-black text-tailor-deep">{{ $portfolio->completed_at->translatedFormat('d F Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <aside class="space-y-5">
            @if($portfolio->tailor)
                <div class="rounded-3xl border border-tailor-purple/10 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-tailor-purple/55">Penjahit</p>
                    <div class="mt-5 flex items-center gap-4">
                        @if($portfolio->tailor->tailorProfile && $portfolio->tailor->tailorProfile->photo)
                            <img src="{{ Storage::url($portfolio->tailor->tailorProfile->photo) }}" alt="{{ $portfolio->tailor->tailorProfile->shop_name }}" class="h-16 w-16 rounded-2xl object-cover ring-4 ring-tailor-soft">
                        @else
                            <div class="grid h-16 w-16 place-items-center rounded-2xl brand-gradient text-xl font-black text-white ring-4 ring-tailor-soft">
                                {{ strtoupper(substr($portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h2 class="truncate font-black text-tailor-deep">{{ $portfolio->tailor->tailorProfile->shop_name ?? $portfolio->tailor->name }}</h2>
                            <p class="mt-1 truncate text-sm font-semibold text-slate-500">{{ $portfolio->tailor->name }}</p>
                        </div>
                    </div>

                    @if($portfolio->tailor->tailorProfile && $portfolio->tailor->tailorProfile->specialization)
                        <p class="mt-4 rounded-2xl bg-tailor-soft px-4 py-3 text-sm font-bold text-tailor-purple">{{ $portfolio->tailor->tailorProfile->specialization }}</p>
                    @endif

                    <a href="{{ route('tailors.show', $portfolio->tailor) }}" class="mt-5 block rounded-2xl brand-gradient px-5 py-3 text-center text-sm font-extrabold text-white shadow-soft">
                        Lihat Profil Penjahit
                    </a>
                </div>
            @endif

            @if($relatedPortfolios->isNotEmpty())
                <div class="rounded-3xl border border-tailor-purple/10 bg-white p-6 shadow-sm">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-tailor-purple/55">Karya Lainnya</p>
                    <div class="mt-5 space-y-3">
                        @foreach($relatedPortfolios as $related)
                            <a href="{{ route('portfolios.show', $related) }}" class="flex gap-3 rounded-2xl p-2 transition hover:bg-tailor-cream">
                                <div class="h-16 w-20 shrink-0 overflow-hidden rounded-xl bg-tailor-soft">
                                    @if($related->image)
                                        <img src="{{ Storage::url($related->image) }}" alt="{{ $related->title }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="grid h-full w-full place-items-center text-tailor-purple/35">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4-4 3 3 5-6 4 5"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="line-clamp-2 text-sm font-black text-tailor-deep">{{ $related->title }}</p>
                                    @if($related->category)
                                        <p class="mt-1 text-xs font-semibold text-slate-400">{{ $related->category }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <a href="{{ route('portfolios.index') }}" class="block rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-5 py-3 text-center text-sm font-extrabold text-tailor-purple">
                Kembali ke Portfolio
            </a>
        </aside>
    </div>
</section>
@endsection
