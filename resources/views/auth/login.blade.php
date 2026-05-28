@extends('layouts.customer')

@section('title', 'Masuk')
@section('fullwidth', true)

@section('content')
<section class="bg-tailor-cream">
    <div class="mx-auto grid min-h-[calc(100vh-5rem)] max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1fr_440px] lg:px-8 lg:py-16">
        <div class="hidden flex-col justify-center lg:flex">
            <span class="inline-flex w-fit rounded-full bg-white px-4 py-2 text-sm font-extrabold text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                TailorTrack Account
            </span>
            <h1 class="mt-6 max-w-2xl text-5xl font-black leading-tight text-tailor-deep">
                Masuk dan pantau pesanan jahit kamu.
            </h1>
            <p class="mt-5 max-w-xl text-base leading-8 text-slate-600">
                Lanjutkan pembayaran, cek progress jahitan, dan kelola detail pesanan dari dashboard customer.
            </p>

            <div class="mt-10 grid max-w-xl grid-cols-3 gap-3">
                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-tailor-purple/10">
                    <p class="text-2xl font-black text-tailor-purple">DP</p>
                    <p class="mt-1 text-xs font-bold text-slate-500">Fleksibel</p>
                </div>
                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-tailor-purple/10">
                    <p class="text-2xl font-black text-tailor-purple">Track</p>
                    <p class="mt-1 text-xs font-bold text-slate-500">Progress</p>
                </div>
                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-tailor-purple/10">
                    <p class="text-2xl font-black text-tailor-purple">Chat</p>
                    <p class="mt-1 text-xs font-bold text-slate-500">Penjahit</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center">
            <div class="w-full max-w-md rounded-[2rem] bg-white p-5 shadow-soft ring-1 ring-tailor-purple/10 sm:p-7">
                <div class="mb-7 text-center">
                    <a href="{{ route('landing') }}" class="mx-auto inline-flex items-center">
                        <img src="{{ asset('storage/images/tailortrack-logo.svg') }}" alt="TailorTrack" class="h-16 w-auto max-w-[230px] object-contain">
                    </a>
                    <h2 class="mt-6 text-2xl font-black text-tailor-deep">Masuk ke akun</h2>
                    <p class="mt-2 text-sm font-semibold text-slate-500">Gunakan email dan kata sandi yang terdaftar.</p>
                </div>

                @if (session('status'))
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-black text-tailor-deep">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@email.com"
                            class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold outline-none transition {{ $errors->has('email') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4"
                        >
                        @error('email')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-black text-tailor-deep">Kata Sandi</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="h-12 w-full rounded-2xl border px-4 pr-12 text-sm font-semibold outline-none transition {{ $errors->has('password') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4"
                            >
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 px-4 text-xs font-black text-tailor-purple">
                                Lihat
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                            <input type="checkbox" name="remember" id="remember_me" class="h-4 w-4 rounded border-tailor-purple/20 text-tailor-purple focus:ring-tailor-purple">
                            Ingat saya
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-black text-tailor-purple hover:text-tailor-deep">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full rounded-2xl brand-gradient px-5 py-3.5 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5">
                        Masuk
                    </button>
                </form>

                <div class="mt-7 border-t border-tailor-purple/10 pt-6 text-center">
                    <p class="text-sm font-semibold text-slate-500">Belum punya akun?</p>
                    <a href="{{ route('register') }}" class="mt-3 block rounded-2xl bg-tailor-soft px-5 py-3 text-sm font-extrabold text-tailor-purple">
                        Daftar Customer
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
