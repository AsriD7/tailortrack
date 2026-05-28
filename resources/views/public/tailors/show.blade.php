@extends('layouts.customer')

@php
    $profile = $tailor->tailorProfile;
    $shopName = $profile->shop_name ?? $tailor->name ?? 'TailorTrack';
    $words = preg_split('/\s+/', trim($shopName));
    $initials = strtoupper(substr($words[0] ?? 'T', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
    $totalOrders = $tailor->tailorOrders()->count();
@endphp

@section('title', $shopName . ' - TailorTrack')
@section('fullwidth', true)

@section('content')
<section class="bg-tailor-cream">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <nav class="mb-8 flex items-center gap-2 text-sm font-semibold text-slate-500">
            <a href="{{ route('landing') }}" class="hover:text-tailor-purple">Beranda</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('tailors.index') }}" class="hover:text-tailor-purple">Penjahit</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="truncate text-tailor-purple">{{ $shopName }}</span>
        </nav>

        <div class="grid gap-8 lg:grid-cols-[1fr_360px] lg:items-start">
            <div class="rounded-[2rem] bg-white p-6 shadow-soft ring-1 ring-tailor-purple/10 sm:p-8">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-start">
                    <div class="relative shrink-0">
                        @if($profile && $profile->photo)
                            <img src="{{ Storage::url($profile->photo) }}" alt="{{ $shopName }}" class="h-28 w-28 rounded-3xl object-cover ring-4 ring-tailor-soft sm:h-32 sm:w-32">
                        @else
                            <div class="grid h-28 w-28 place-items-center rounded-3xl brand-gradient text-4xl font-black text-white ring-4 ring-tailor-soft sm:h-32 sm:w-32">
                                {{ $initials }}
                            </div>
                        @endif
                        <span class="absolute -bottom-2 left-3 rounded-full px-3 py-1 text-xs font-black shadow-sm {{ $profile && $profile->is_available ? 'bg-emerald-500 text-white' : 'bg-slate-500 text-white' }}">
                            {{ $profile && $profile->is_available ? 'Tersedia' : 'Sibuk' }}
                        </span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-3">
                            <h1 class="text-3xl font-black leading-tight text-tailor-deep sm:text-4xl">{{ $shopName }}</h1>
                            @if($profile && $profile->is_verified)
                                <span class="rounded-full bg-tailor-soft px-3 py-1 text-xs font-black text-tailor-purple">Terverifikasi</span>
                            @endif
                        </div>
                        <p class="mt-2 text-base font-semibold text-slate-500">{{ $tailor->name }}</p>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @if($profile && $profile->specialization)
                                <span class="rounded-full bg-tailor-soft px-3 py-2 text-xs font-black text-tailor-purple">{{ $profile->specialization }}</span>
                            @endif
                            @if($profile && $profile->experience_years)
                                <span class="rounded-full bg-tailor-cream px-3 py-2 text-xs font-black text-tailor-deep">{{ $profile->experience_years }} tahun pengalaman</span>
                            @endif
                            <span class="rounded-full bg-tailor-cream px-3 py-2 text-xs font-black text-tailor-deep">{{ $tailor->portfolios->count() }} portfolio</span>
                            @if($reviewCount > 0)
                                <span class="rounded-full bg-tailor-gold/25 px-3 py-2 text-xs font-black text-tailor-deep">{{ number_format($avgRating, 1) }} rating</span>
                            @endif
                        </div>

                        @if($profile && $profile->description)
                            <p class="mt-6 whitespace-pre-line text-sm leading-8 text-slate-600">{{ $profile->description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <aside class="rounded-[2rem] border border-tailor-purple/10 bg-white p-5 shadow-soft">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-tailor-purple/55">Buat Pesanan</p>

                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="rounded-2xl bg-tailor-cream p-4">
                        <p class="text-xs font-bold text-slate-400">Antrean</p>
                        <p class="mt-1 font-black text-tailor-deep">{{ $activeOrdersCount }}{{ $profile?->max_active_orders ? ' / ' . $profile->max_active_orders : '' }}</p>
                    </div>
                    <div class="rounded-2xl bg-tailor-cream p-4">
                        <p class="text-xs font-bold text-slate-400">Estimasi</p>
                        <p class="mt-1 font-black text-tailor-deep">{{ $profile?->estimated_processing_days ? $profile->estimated_processing_days . ' hari' : 'Konfirmasi' }}</p>
                    </div>
                </div>

                @if($workingDayLabels->isNotEmpty())
                    <div class="mt-4 rounded-2xl bg-tailor-soft p-4">
                        <p class="text-xs font-bold text-tailor-purple/70">Hari Kerja</p>
                        <p class="mt-1 text-sm font-black text-tailor-deep">{{ $workingDayLabels->implode(', ') }}</p>
                    </div>
                @endif

                @if($unavailableDates->isNotEmpty())
                    <div class="mt-4 rounded-2xl bg-red-50 p-4">
                        <p class="text-xs font-bold text-red-500">Tanggal Tidak Tersedia</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach($unavailableDates as $date)
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-black text-red-600 ring-1 ring-red-100">{{ $date->date->format('d M Y') }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($isAtCapacity)
                    <div class="mt-4 rounded-2xl bg-red-50 p-4 text-sm font-semibold leading-7 text-red-700">
                        Antrean penjahit sedang penuh. Pesanan baru belum dapat dibuat saat ini.
                    </div>
                @endif

                <div class="mt-5">
                    @auth
                        @if(auth()->user()->isCustomer() && !$isAtCapacity)
                            <a href="{{ route('customer.orders.create', $tailor->id) }}" class="block rounded-2xl brand-gradient px-5 py-3.5 text-center text-sm font-extrabold text-white shadow-soft">
                                Buat Pesanan Sekarang
                            </a>
                        @elseif(auth()->user()->isCustomer() && $isAtCapacity)
                            <div class="rounded-2xl bg-slate-100 px-5 py-3.5 text-center text-sm font-extrabold text-slate-400">
                                Antrean Sedang Penuh
                            </div>
                        @else
                            <div class="rounded-2xl bg-slate-100 px-5 py-3.5 text-center text-sm font-extrabold text-slate-400">
                                Login sebagai pelanggan untuk memesan
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block rounded-2xl brand-gradient px-5 py-3.5 text-center text-sm font-extrabold text-white shadow-soft">
                            Login untuk Memesan
                        </a>
                        <a href="{{ route('register') }}" class="mt-3 block rounded-2xl bg-tailor-soft px-5 py-3 text-center text-sm font-extrabold text-tailor-purple">
                            Belum punya akun? Daftar
                        </a>
                    @endauth

                    @if($profile && $profile->phone)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $profile->phone) }}?text=Halo, saya tertarik dengan layanan jahit Anda di TailorTrack." target="_blank" rel="noopener" class="mt-3 block rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-center text-sm font-extrabold text-emerald-700">
                            Chat via WhatsApp
                        </a>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="bg-white py-12">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_360px] lg:px-8">
        <div class="space-y-8">
            @if($profile && ($profile->address || $profile->phone || $profile->city || $tailor->email))
                <div class="rounded-3xl border border-tailor-purple/10 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-black text-tailor-deep">Lokasi dan Kontak</h2>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @if($profile->address || $profile->city)
                            <div class="rounded-2xl bg-tailor-cream p-4">
                                <p class="text-xs font-bold text-slate-400">Alamat</p>
                                <p class="mt-1 text-sm font-semibold leading-6 text-tailor-deep">{{ $profile->address }}{{ $profile->address && $profile->city ? ', ' : '' }}{{ $profile->city }}</p>
                            </div>
                        @endif
                        @if($profile->phone)
                            <div class="rounded-2xl bg-tailor-cream p-4">
                                <p class="text-xs font-bold text-slate-400">Telepon / WhatsApp</p>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $profile->phone) }}" target="_blank" rel="noopener" class="mt-1 block text-sm font-black text-tailor-purple">{{ $profile->phone }}</a>
                            </div>
                        @endif
                        @if($tailor->email)
                            <div class="rounded-2xl bg-tailor-cream p-4">
                                <p class="text-xs font-bold text-slate-400">Email</p>
                                <p class="mt-1 text-sm font-semibold text-tailor-deep">{{ $tailor->email }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="rounded-3xl border border-tailor-purple/10 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-black text-tailor-deep">Portfolio</h2>
                        <p class="mt-1 text-sm font-semibold text-slate-500">{{ $tailor->portfolios->count() }} karya</p>
                    </div>
                </div>

                @if($tailor->portfolios->isNotEmpty())
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        @foreach($tailor->portfolios as $portfolio)
                            <a href="{{ route('portfolios.show', $portfolio) }}" class="group overflow-hidden rounded-3xl border border-tailor-purple/10 bg-white shadow-sm">
                                <div class="aspect-[4/3] overflow-hidden bg-tailor-soft">
                                    @if($portfolio->image)
                                        <img src="{{ $portfolio->imageUrl }}" alt="{{ $portfolio->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="grid h-full w-full place-items-center text-tailor-purple/35">
                                            <svg class="h-12 w-12" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4-4 3 3 5-6 4 5"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="line-clamp-1 font-black text-tailor-deep">{{ $portfolio->title }}</h3>
                                    @if($portfolio->category)
                                        <p class="mt-1 text-xs font-bold text-tailor-purple">{{ $portfolio->category }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 rounded-3xl border border-dashed border-tailor-purple/20 bg-tailor-cream p-8 text-center">
                        <p class="font-black text-tailor-deep">Belum ada portfolio.</p>
                        <p class="mt-2 text-sm text-slate-500">Hasil karya penjahit akan tampil di sini.</p>
                    </div>
                @endif
            </div>
        </div>

        <aside class="space-y-5">
            <div class="rounded-3xl border border-tailor-purple/10 bg-white p-6 shadow-sm">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-tailor-purple/55">Informasi Singkat</p>
                <div class="mt-5 space-y-3 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-semibold text-slate-500">Status</span>
                        <span class="font-black {{ $profile && $profile->is_available ? 'text-emerald-600' : 'text-red-600' }}">{{ $profile && $profile->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                    </div>
                    @if($profile && $profile->experience_years)
                        <div class="flex items-center justify-between gap-3">
                            <span class="font-semibold text-slate-500">Pengalaman</span>
                            <span class="font-black text-tailor-deep">{{ $profile->experience_years }} tahun</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-semibold text-slate-500">Portfolio</span>
                        <span class="font-black text-tailor-deep">{{ $tailor->portfolios->count() }} karya</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="font-semibold text-slate-500">Pesanan</span>
                        <span class="font-black text-tailor-deep">{{ $totalOrders }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('tailors.index') }}" class="block rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-5 py-3 text-center text-sm font-extrabold text-tailor-purple">
                Kembali ke Daftar Penjahit
            </a>
        </aside>
    </div>
</section>

<section class="bg-tailor-cream py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-tailor-deep">Ulasan Pelanggan</h2>
                <p class="mt-1 text-sm font-semibold text-slate-500">{{ $reviewCount }} ulasan dari pelanggan</p>
            </div>
        </div>

        @if($reviewCount > 0)
            <div class="grid gap-6 lg:grid-cols-[320px_1fr]">
                <div class="rounded-3xl bg-white p-6 text-center shadow-sm ring-1 ring-tailor-purple/10">
                    <p class="text-6xl font-black text-tailor-gold">{{ number_format($avgRating, 1) }}</p>
                    <p class="mt-2 text-sm font-semibold text-slate-500">dari {{ $reviewCount }} ulasan</p>
                    <div class="mt-5 space-y-2">
                        @foreach($ratingBreakdown as $star => $data)
                            <div class="flex items-center gap-2 text-xs">
                                <span class="w-5 text-right font-bold text-slate-500">{{ $star }}</span>
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-tailor-soft">
                                    <div class="h-full rounded-full gold-gradient" style="width: {{ $data['percent'] }}%"></div>
                                </div>
                                <span class="w-6 text-left font-bold text-slate-400">{{ $data['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-10 w-10 place-items-center rounded-2xl brand-gradient text-sm font-black text-white">
                                        {{ strtoupper(substr($review->customer->name ?? 'C', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-tailor-deep">{{ $review->customer->name ?? 'Pelanggan' }}</p>
                                        <p class="text-xs font-semibold text-slate-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-tailor-gold/20 px-3 py-1 text-xs font-black text-tailor-deep">{{ $review->rating_label }}</span>
                            </div>
                            <p class="mt-4 rounded-2xl bg-tailor-cream p-4 text-sm leading-7 text-slate-600">{{ $review->comment ?: 'Tidak ada komentar.' }}</p>
                        </div>
                    @endforeach

                    @if($reviews->hasPages())
                        <div class="pt-2">{{ $reviews->links() }}</div>
                    @endif
                </div>
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-tailor-purple/20 bg-white p-10 text-center">
                <p class="font-black text-tailor-deep">Belum ada ulasan</p>
                <p class="mt-2 text-sm text-slate-500">Ulasan akan tampil setelah pelanggan menyelesaikan pesanan.</p>
            </div>
        @endif
    </div>
</section>
@endsection
