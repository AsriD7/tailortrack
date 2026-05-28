@extends('layouts.customer')

@section('title', 'Daftar Harga Layanan - TailorTrack')
@section('fullwidth', true)

@section('content')
<section class="bg-tailor-cream">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <nav class="mb-8 flex items-center gap-2 text-sm font-semibold text-slate-500">
            <a href="{{ route('landing') }}" class="hover:text-tailor-purple">Beranda</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-tailor-purple">Daftar Harga</span>
        </nav>

        <div class="grid gap-8 lg:grid-cols-[1fr_0.62fr] lg:items-end">
            <div>
                <span class="inline-flex rounded-full bg-white px-4 py-2 text-sm font-extrabold text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                    Harga dasar layanan
                </span>
                <h1 class="mt-5 max-w-3xl text-4xl font-black leading-tight text-tailor-deep sm:text-5xl">
                    Cek estimasi harga sebelum membuat pesanan.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600">
                    Harga di bawah adalah harga dasar per item. Total akhir tetap dikonfirmasi penjahit setelah detail pesanan dan ukuran dicek.
                </p>
            </div>
            <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-tailor-purple/10">
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-2xl bg-tailor-cream p-4">
                        <p class="text-3xl font-black text-tailor-purple">{{ $priceLists->count() }}</p>
                        <p class="mt-1 text-xs font-bold text-slate-500">Layanan</p>
                    </div>
                    <div class="rounded-2xl bg-tailor-cream p-4">
                        <p class="text-3xl font-black text-tailor-purple">{{ count($grouped) }}</p>
                        <p class="mt-1 text-xs font-bold text-slate-500">Kategori</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-tailor-gold/30 bg-tailor-cream p-5 sm:p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-tailor-gold/25 text-tailor-deep">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-tailor-deep">Informasi biaya tambahan ukuran</h2>
                    <p class="mt-2 text-sm leading-7 text-slate-600">
                        Harga dasar berlaku untuk ukuran S dan M. Ukuran lebih besar dapat dikenakan biaya tambahan sesuai kebijakan layanan.
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach([['L', 5000], ['XL', 10000], ['XXL', 15000], ['Custom', 20000]] as [$size, $amount])
                            <span class="rounded-full bg-white px-3 py-2 text-xs font-black text-tailor-deep shadow-sm ring-1 ring-tailor-purple/10">
                                {{ $size }} + Rp {{ number_format($amount, 0, ',', '.') }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white pb-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if($priceLists->isNotEmpty())
            @if(!empty($grouped) && count($grouped) > 0)
                <div class="space-y-6">
                    @foreach($grouped as $category => $items)
                        <div class="overflow-hidden rounded-3xl border border-tailor-purple/10 bg-white shadow-sm">
                            <div class="flex items-center justify-between gap-4 border-b border-tailor-purple/10 bg-tailor-cream px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-10 w-10 place-items-center rounded-2xl brand-gradient text-white">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.5 0 1 .2 1.4.6l7 7a2 2 0 010 2.8l-7 7a2 2 0 01-2.8 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="font-black text-tailor-deep">{{ $category ?: 'Layanan Umum' }}</h2>
                                        <p class="text-xs font-semibold text-slate-500">{{ count($items) }} layanan</p>
                                    </div>
                                </div>
                            </div>

                            <div class="divide-y divide-tailor-purple/10">
                                @foreach($items as $priceList)
                                    <div class="grid gap-3 px-5 py-4 sm:grid-cols-[1fr_auto] sm:items-center sm:px-6">
                                        <div>
                                            <h3 class="font-black text-tailor-deep">{{ $priceList->name }}</h3>
                                            <p class="mt-1 text-sm leading-6 text-slate-500">{{ $priceList->description ?: 'Deskripsi belum tersedia.' }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-tailor-soft px-4 py-3 text-right">
                                            <p class="text-xs font-bold text-tailor-purple/70">Harga Dasar</p>
                                            <p class="mt-1 font-black text-tailor-deep">Rp {{ number_format($priceList->base_price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($priceLists as $priceList)
                        <div class="rounded-3xl border border-tailor-purple/10 bg-white p-5 shadow-sm">
                            <span class="rounded-full bg-tailor-soft px-3 py-1 text-xs font-black text-tailor-purple">{{ $priceList->category ?: 'Layanan Umum' }}</span>
                            <h3 class="mt-4 font-black text-tailor-deep">{{ $priceList->name }}</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-500">{{ $priceList->description ?: 'Deskripsi belum tersedia.' }}</p>
                            <p class="mt-5 text-lg font-black text-tailor-purple">Rp {{ number_format($priceList->base_price, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-10 rounded-[2rem] brand-gradient p-7 text-white shadow-soft sm:p-8">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-black">Sudah cocok dengan estimasi harganya?</h2>
                        <p class="mt-2 max-w-xl text-sm leading-7 text-white/75">Pilih penjahit dan kirim detail pesanan agar harga final bisa dikonfirmasi.</p>
                    </div>
                    <a href="{{ route('tailors.index') }}" class="rounded-2xl bg-white px-6 py-3 text-center text-sm font-extrabold text-tailor-purple">
                        Cari Penjahit
                    </a>
                </div>
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-tailor-purple/20 bg-tailor-cream p-10 text-center sm:p-14">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-white text-tailor-purple shadow-sm">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.5 0 1 .2 1.4.6l7 7a2 2 0 010 2.8l-7 7a2 2 0 01-2.8 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-black text-tailor-deep">Belum ada daftar harga</h2>
                <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-500">Informasi harga layanan belum tersedia. Silakan cek profil penjahit secara langsung.</p>
                <a href="{{ route('tailors.index') }}" class="mt-7 inline-flex rounded-2xl brand-gradient px-6 py-3 text-sm font-extrabold text-white shadow-soft">
                    Cari Penjahit
                </a>
            </div>
        @endif
    </div>
</section>
@endsection
