@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <section class="rounded-[2rem] bg-tailor-cream p-5 shadow-sm ring-1 ring-tailor-purple/10 sm:p-7">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-black text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">Profil Customer</span>
                <h1 class="mt-5 text-3xl font-black text-tailor-deep">Profil Saya</h1>
                <p class="mt-2 text-sm leading-7 text-slate-600">Perbarui informasi akun dan kontak untuk kebutuhan pesanan.</p>
            </div>
            <a href="{{ route('customer.dashboard') }}" class="rounded-2xl bg-white px-5 py-3 text-center text-sm font-extrabold text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">
                Kembali
            </a>
        </div>
    </section>

    <section class="overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-tailor-purple/10">
        <div class="grid lg:grid-cols-[320px_1fr]">
            <aside class="brand-gradient p-6 text-white">
                <div class="grid h-20 w-20 place-items-center rounded-3xl bg-white/15 text-3xl font-black shadow-inner">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="mt-5 text-xl font-black">{{ $user->name }}</h2>
                <p class="mt-1 break-all text-sm font-semibold text-white/65">{{ $user->email }}</p>

                <div class="mt-6 space-y-3">
                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-xs font-bold text-white/60">Nomor Telepon</p>
                        <p class="mt-1 text-sm font-black">{{ $user->phone ?: 'Belum diisi' }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-xs font-bold text-white/60">Alamat</p>
                        <p class="mt-1 text-sm font-black leading-7">{{ $user->address ?: 'Belum diisi' }}</p>
                    </div>
                </div>
            </aside>

            <div class="p-5 sm:p-7">
                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-black">Terdapat kesalahan pada formulir:</p>
                        <ul class="mt-2 list-inside list-disc space-y-1 text-xs font-semibold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-2 block text-sm font-black text-tailor-deep">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                   class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold outline-none transition {{ $errors->has('name') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4">
                            @error('name') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-sm font-black text-tailor-deep">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold outline-none transition {{ $errors->has('email') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4">
                            @error('email') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="mb-2 block text-sm font-black text-tailor-deep">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xx-xxxx-xxxx"
                               class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold outline-none transition {{ $errors->has('phone') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4">
                        @error('phone') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="address" class="mb-2 block text-sm font-black text-tailor-deep">Alamat</label>
                        <textarea id="address" name="address" rows="4" placeholder="Alamat lengkap untuk kebutuhan komunikasi pesanan"
                                  class="w-full rounded-2xl border px-4 py-3 text-sm font-semibold outline-none transition {{ $errors->has('address') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-tailor-cream focus:border-tailor-gold focus:bg-white focus:ring-tailor-gold/20' }} focus:ring-4">{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="rounded-3xl bg-tailor-cream p-5">
                        <h3 class="font-black text-tailor-deep">Ubah Password</h3>
                        <p class="mt-1 text-xs font-semibold text-slate-500">Kosongkan bagian ini jika tidak ingin mengganti password.</p>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="mb-2 block text-sm font-black text-tailor-deep">Password Baru</label>
                                <input type="password" id="password" name="password" autocomplete="new-password"
                                       class="h-12 w-full rounded-2xl border px-4 text-sm font-semibold outline-none transition {{ $errors->has('password') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-tailor-purple/10 bg-white focus:border-tailor-gold focus:ring-tailor-gold/20' }} focus:ring-4">
                                @error('password') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-black text-tailor-deep">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                                       class="h-12 w-full rounded-2xl border border-tailor-purple/10 bg-white px-4 text-sm font-semibold outline-none transition focus:border-tailor-gold focus:ring-4 focus:ring-tailor-gold/20">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                        <a href="{{ route('customer.dashboard') }}" class="rounded-2xl bg-slate-100 px-5 py-3 text-center text-sm font-extrabold text-slate-600">
                            Batal
                        </a>
                        <button type="submit" class="rounded-2xl brand-gradient px-6 py-3 text-sm font-extrabold text-white shadow-soft">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
