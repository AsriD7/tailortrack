@extends('layouts.customer')

@section('title', 'Daftar')
@section('fullwidth', true)

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50">

    {{-- Background decorative blobs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-32 w-96 h-96 bg-indigo-200 rounded-full opacity-30 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-32 w-96 h-96 bg-purple-200 rounded-full opacity-30 blur-3xl"></div>
        <div class="absolute top-1/3 left-1/4 w-48 h-48 bg-violet-100 rounded-full opacity-20 blur-2xl"></div>
    </div>

    <div class="relative w-full max-w-lg">

        {{-- Logo / Wordmark --}}
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:shadow-indigo-500/50 transition-shadow duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    TailorTrack
                </span>
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/70 border border-slate-100 overflow-hidden">

            {{-- Card Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-8">
                <h1 class="text-2xl font-bold text-white">Buat Akun Customer</h1>
                <p class="text-indigo-100 mt-1 text-sm font-medium">Bergabung dan pesan jahitan terbaik untukmu ✨</p>
            </div>

            {{-- Admin Note Banner --}}
            <div class="mx-8 mt-6 flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3.5">
                <div class="flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-xs text-amber-700 leading-relaxed">
                    <span class="font-semibold">Catatan:</span> Halaman ini untuk pendaftaran akun <span class="font-semibold">Customer</span>. Akun Tailor hanya dapat dibuat oleh Administrator.
                </p>
            </div>

            {{-- Card Body --}}
            <div class="px-8 py-6">

                {{-- General Errors --}}
                @if ($errors->any())
                    <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-semibold mb-1">Terdapat kesalahan pada formulir:</p>
                            <ul class="list-disc list-inside space-y-0.5 text-xs">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Nama lengkap Anda"
                                class="w-full pl-10 pr-4 py-2.5 border {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-200"
                            >
                        </div>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="username"
                                placeholder="nama@email.com"
                                class="w-full pl-10 pr-4 py-2.5 border {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-200"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Kata Sandi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Min. 8 karakter"
                                class="w-full pl-10 pr-11 py-2.5 border {{ $errors->has('password') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-200"
                            >
                            <button type="button"
                                onclick="togglePassword('password', this)"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi kata sandi"
                                class="w-full pl-10 pr-11 py-2.5 border {{ $errors->has('password_confirmation') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-200"
                            >
                            <button type="button"
                                onclick="togglePassword('password_confirmation', this)"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Divider: Optional fields --}}
                    <div class="relative pt-1">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-dashed border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-3 bg-white text-xs text-slate-400 font-medium">Informasi Tambahan (Opsional)</span>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Nomor Telepon
                            <span class="text-xs text-slate-400 font-normal ml-1">(opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                autocomplete="tel"
                                placeholder="08xx-xxxx-xxxx"
                                class="w-full pl-10 pr-4 py-2.5 border {{ $errors->has('phone') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-200"
                            >
                        </div>
                        @error('phone')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="address" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Alamat
                            <span class="text-xs text-slate-400 font-normal ml-1">(opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-3.5 flex items-start pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <textarea
                                id="address"
                                name="address"
                                rows="2"
                                autocomplete="street-address"
                                placeholder="Jl. Contoh No. 1, Kota"
                                class="w-full pl-10 pr-4 py-2.5 border {{ $errors->has('address') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-200 resize-none"
                            >{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Terms note --}}
                    <p class="text-xs text-slate-500 leading-relaxed pt-1">
                        Dengan mendaftar, Anda menyetujui
                        <a href="#" class="text-indigo-600 hover:underline font-medium">Syarat & Ketentuan</a>
                        serta
                        <a href="#" class="text-indigo-600 hover:underline font-medium">Kebijakan Privasi</a>
                        TailorTrack.
                    </p>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold text-sm hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 active:scale-[0.99]"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Buat Akun Sekarang
                        </span>
                    </button>

                </form>
            </div>

            {{-- Card Footer --}}
            <div class="px-8 pb-8">
                <div class="relative mb-5">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-100"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-white text-xs text-slate-400 font-medium">Sudah punya akun?</span>
                    </div>
                </div>

                <a href="{{ route('login') }}"
                   class="block w-full text-center py-2.5 px-4 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-700 hover:border-indigo-300 hover:text-indigo-700 hover:bg-indigo-50 transition-all duration-200">
                    Masuk ke Akun
                </a>
            </div>

        </div>

        {{-- Bottom note --}}
        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} TailorTrack. Platform jasa jahit terpercaya.
        </p>

    </div>
</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        const icon = btn.querySelector('.eye-icon');
        if (isPassword) {
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>
@endsection
