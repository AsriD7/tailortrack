@extends('layouts.customer')

@section('title', 'Daftar')
@section('fullwidth', true)

@section('content')
<section class="bg-tailor-cream">
    <div class="mx-auto grid min-h-[calc(100vh-5rem)] max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1fr_520px] lg:px-8 lg:py-16">
        <div class="hidden flex-col justify-center lg:flex">
            <span class="inline-flex w-fit rounded-full bg-white px-4 py-2 text-sm font-extrabold text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                Customer Account
            </span>
            <h1 class="mt-6 max-w-2xl text-5xl font-black leading-tight text-tailor-deep">
                Buat akun untuk mulai pesan jahitan custom.
            </h1>
            <p class="mt-5 max-w-xl text-base leading-8 text-slate-600">
                Akun customer dipakai untuk membuat pesanan, upload bukti pembayaran, dan memantau progress dari penjahit.
            </p>

            <div class="mt-10 rounded-[2rem] bg-white p-6 shadow-soft ring-1 ring-tailor-purple/10">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-tailor-purple/55">Alur Singkat</p>
                <div class="mt-5 space-y-4">
                    @foreach(['Daftar akun customer', 'Pilih penjahit dan isi pesanan', 'Bayar DP atau full lalu pantau progress'] as $index => $step)
                        <div class="flex items-center gap-3">
                            <div class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-tailor-purple text-xs font-black text-white">{{ $index + 1 }}</div>
                            <p class="text-sm font-bold text-slate-600">{{ $step }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center">
            <div class="w-full max-w-lg rounded-[2rem] bg-white p-5 shadow-soft ring-1 ring-tailor-purple/10 sm:p-7">
                <div class="mb-7 text-center">
                    <a href="{{ route('landing') }}" class="mx-auto inline-flex items-center">
                        <img src="{{ asset('images/tailortrack-logo.svg') }}" alt="TailorTrack" class="h-16 w-auto max-w-[230px] object-contain">
                    </a>
                    <h2 class="mt-6 text-2xl font-black text-tailor-deep">Buat akun customer</h2>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Akun tailor dibuat oleh admin.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-black">Periksa kembali form pendaftaran.</p>
                        <ul class="mt-2 list-inside list-disc space-y-1 text-xs font-semibold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-black text-tailor-deep">Nama Lengkap</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Nama lengkap"
                            class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold outline-none transition {{ $errors->has('name') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4"
                        >
                        @error('name')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-black text-tailor-deep">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="nama@email.com"
                            class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold outline-none transition {{ $errors->has('email') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4"
                        >
                        @error('email')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="password" class="mb-2 block text-sm font-black text-tailor-deep">Kata Sandi</label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Min. 8 karakter"
                                    class="h-12 w-full rounded-2xl border px-4 pr-12 text-sm font-semibold outline-none transition {{ $errors->has('password') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4"
                                >
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 px-4 text-xs font-black text-tailor-purple">Lihat</button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-black text-tailor-deep">Konfirmasi</label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Ulangi sandi"
                                    class="h-12 w-full rounded-2xl border px-4 pr-12 text-sm font-semibold outline-none transition {{ $errors->has('password_confirmation') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4"
                                >
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 px-4 text-xs font-black text-tailor-purple">Lihat</button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="rounded-3xl bg-tailor-cream p-4">
                        <p class="text-xs font-black uppercase tracking-[0.14em] text-tailor-purple/60">Opsional</p>
                        <div class="mt-4 grid gap-5">
                            <div>
                                <label for="phone" class="mb-2 block text-sm font-black text-tailor-deep">Nomor Telepon</label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    autocomplete="tel"
                                    placeholder="08xx-xxxx-xxxx"
                                    class="h-12 w-full rounded-2xl border border-tailor-purple/10 bg-white px-4 text-sm font-semibold outline-none transition focus:border-tailor-gold focus:ring-4 focus:ring-tailor-gold/20"
                                >
                                @error('phone')
                                    <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="mb-2 block text-sm font-black text-tailor-deep">Alamat</label>
                                <textarea
                                    id="address"
                                    name="address"
                                    rows="2"
                                    autocomplete="street-address"
                                    placeholder="Alamat pengiriman atau domisili"
                                    class="w-full rounded-2xl border border-tailor-purple/10 bg-white px-4 py-3 text-sm font-semibold outline-none transition focus:border-tailor-gold focus:ring-4 focus:ring-tailor-gold/20"
                                >{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <p class="text-xs leading-6 text-slate-500">
                        Dengan mendaftar, kamu menyetujui penggunaan akun untuk pemesanan, pembayaran, dan tracking pesanan TailorTrack.
                    </p>

                    <button type="submit" class="w-full rounded-2xl brand-gradient px-5 py-3.5 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5">
                        Buat Akun
                    </button>
                </form>

                <div class="mt-7 border-t border-tailor-purple/10 pt-6 text-center">
                    <p class="text-sm font-semibold text-slate-500">Sudah punya akun?</p>
                    <a href="{{ route('login') }}" class="mt-3 block rounded-2xl bg-tailor-soft px-5 py-3 text-sm font-extrabold text-tailor-purple">
                        Masuk ke Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endpush
@endsection
