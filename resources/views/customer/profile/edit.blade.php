@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Profil Saya</h1>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi akun dan kontak Anda.</p>
            </div>
            <a href="{{ route('customer.dashboard') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3">
            <aside class="p-6 bg-gradient-to-br from-indigo-600 to-purple-700 text-white">
                <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center text-3xl font-extrabold shadow-inner mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="text-lg font-bold">{{ $user->name }}</h2>
                <p class="text-indigo-100 text-sm mt-1 break-all">{{ $user->email }}</p>

                <div class="mt-6 space-y-3 text-sm">
                    <div class="bg-white/10 rounded-xl p-4">
                        <p class="text-indigo-100 text-xs font-medium">Nomor Telepon</p>
                        <p class="font-semibold mt-1">{{ $user->phone ?: 'Belum diisi' }}</p>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <p class="text-indigo-100 text-xs font-medium">Alamat</p>
                        <p class="font-semibold mt-1 leading-relaxed">{{ $user->address ?: 'Belum diisi' }}</p>
                    </div>
                </div>
            </aside>

            <section class="lg:col-span-2 p-6">
                @if ($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                        <p class="font-semibold mb-1">Terdapat kesalahan pada formulir:</p>
                        <ul class="list-disc list-inside space-y-0.5 text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-4 py-2.5 border {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                            >
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-4 py-2.5 border {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                            >
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Nomor Telepon
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="08xx-xxxx-xxxx"
                            class="w-full px-4 py-2.5 border {{ $errors->has('phone') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                        >
                        @error('phone')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Alamat
                        </label>
                        <textarea
                            id="address"
                            name="address"
                            rows="4"
                            placeholder="Alamat lengkap untuk kebutuhan komunikasi pesanan"
                            class="w-full px-4 py-2.5 border {{ $errors->has('address') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent resize-none"
                        >{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100 pt-6">
                        <h3 class="font-bold text-slate-800 text-sm">Ubah Password</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-4">Kosongkan bagian ini jika tidak ingin mengganti password.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Password Baru
                                </label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    autocomplete="new-password"
                                    class="w-full px-4 py-2.5 border {{ $errors->has('password') ? 'border-red-400 bg-red-50 focus:ring-red-400' : 'border-slate-200 focus:ring-indigo-500' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                                >
                                @error('password')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Konfirmasi Password Baru
                                </label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    autocomplete="new-password"
                                    class="w-full px-4 py-2.5 border border-slate-200 focus:ring-indigo-500 rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
                        <a href="{{ route('customer.dashboard') }}"
                           class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all shadow-md shadow-indigo-200"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
