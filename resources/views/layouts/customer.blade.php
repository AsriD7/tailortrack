<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta-description', 'TailorTrack - Platform pemesanan jasa jahit custom, tracking pesanan, portofolio penjahit, dan pembayaran sederhana.')">
    <title>@yield('title', 'TailorTrack') - Platform Jasa Jahit Custom</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage\images\tailortrack-icon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    colors: {
                        tailor: {
                            purple: '#4C0D7A',
                            deep: '#2E064F',
                            gold: '#F0B34F',
                            cream: '#FFF9F0',
                            soft: '#F3E8FF',
                            ink: '#1F1330'
                        }
                    },
                    boxShadow: {
                        soft: '0 18px 45px -18px rgba(76, 13, 122, 0.28)',
                        gold: '0 16px 35px -18px rgba(240, 179, 79, 0.75)'
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .brand-gradient { background: linear-gradient(135deg, #4C0D7A 0%, #6D28D9 55%, #2E064F 100%); }
        .brand-text { background: linear-gradient(135deg, #4C0D7A 0%, #6D28D9 65%, #F0B34F 105%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
        .gold-gradient { background: linear-gradient(135deg, #F8D48B 0%, #F0B34F 100%); }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(18px); border-bottom: 1px solid rgba(76, 13, 122, 0.08); }
        .nav-link { position: relative; color: #6B6475; transition: color .18s ease; }
        .nav-link::after { content: ''; position: absolute; left: 1rem; right: 1rem; bottom: -1.08rem; height: 3px; border-radius: 999px; background: linear-gradient(90deg, #4C0D7A, #F0B34F); transform: scaleX(0); transform-origin: center; transition: transform .22s ease; }
        .nav-link:hover, .nav-link.active { color: #4C0D7A; }
        .nav-link:hover::after, .nav-link.active::after { transform: scaleX(1); }
        .brand-logo { display: block; height: auto; object-fit: contain; }
        ::-webkit-scrollbar { width: 7px; height: 7px; }
        ::-webkit-scrollbar-track { background: #FFF9F0; }
        ::-webkit-scrollbar-thumb { background: #D7B7F1; border-radius: 999px; }
    </style>

    @stack('styles')
</head>

<body class="flex min-h-screen flex-col bg-tailor-cream text-tailor-ink antialiased">
    @php
        $dashboardRoute = null;
        if (auth()->check()) {
            $role = auth()->user()->role;
            $dashboardRoute = match($role) {
                \App\Enums\UserRole::Admin => route('admin.dashboard'),
                \App\Enums\UserRole::Tailor => route('tailor.dashboard'),
                default => route('customer.dashboard'),
            };
        }

        $pendingCount = 0;
        if (auth()->check() && auth()->user()->role === \App\Enums\UserRole::Customer && method_exists(auth()->user(), 'customerOrders')) {
            $pendingCount = auth()->user()->customerOrders()->whereIn('status', ['menunggu_pembayaran', 'menunggu_konfirmasi'])->count();
        }
    @endphp

    @if(session('success'))
        <div id="flash-success" class="fixed right-5 top-5 z-[100] max-w-sm rounded-2xl border border-emerald-200 bg-white px-5 py-4 text-sm font-semibold text-emerald-700 shadow-soft">
            <div class="flex items-start gap-3">
                <span class="grid h-8 w-8 place-items-center rounded-full bg-emerald-50 text-xs font-black">OK</span>
                <span class="pt-1">{{ session('success') }}</span>
                <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-slate-400 hover:text-slate-700">x</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error" class="fixed right-5 top-5 z-[100] max-w-sm rounded-2xl border border-red-200 bg-white px-5 py-4 text-sm font-semibold text-red-700 shadow-soft">
            <div class="flex items-start gap-3">
                <span class="grid h-8 w-8 place-items-center rounded-full bg-red-50 font-black">!</span>
                <span class="pt-1">{{ session('error') }}</span>
                <button onclick="document.getElementById('flash-error').remove()" class="ml-auto text-slate-400 hover:text-slate-700">x</button>
            </div>
        </div>
    @endif

    <div class="hidden border-b border-tailor-purple/10 bg-tailor-deep text-white lg:block">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2 text-xs sm:px-6 lg:px-8">
            <div class="flex items-center gap-6 text-white/80">
                <span class="inline-flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-tailor-gold"></span> Platform jasa jahit custom berbasis tracking</span>
                <span>Upload desain - Pantau pesanan - Pembayaran terverifikasi</span>
            </div>
            <div class="flex items-center gap-5 text-white/80">
                @auth
                    <a href="{{ $dashboardRoute }}" class="hover:text-tailor-gold">
                        {{ auth()->user()->role === \App\Enums\UserRole::Customer ? 'Dashboard Saya' : 'Dashboard' }}
                    </a>
                    @if(auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a href="{{ route('customer.orders.index') }}" class="hover:text-tailor-gold">Pesanan Saya</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-tailor-gold">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-tailor-gold">Masuk</a>
                    <a href="{{ route('register') }}" class="hover:text-tailor-gold">Daftar</a>
                @endauth
            </div>
        </div>
    </div>

    <nav class="glass-nav sticky top-0 z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between gap-4">
                <a href="{{ route('landing') }}" class="flex shrink-0 items-center gap-3" aria-label="TailorTrack Home">
                    <img src="{{ asset('storage\images\tailortrack-icon.svg') }}" alt="" class="brand-logo h-12 w-12 rounded-2xl shadow-soft ring-1 ring-tailor-purple/10">
                    <span class="text-2xl font-black tracking-tight brand-text">TailorTrack</span>
                </a>

                <div class="hidden flex-1 justify-center lg:flex">
                    <form action="{{ route('tailors.index') }}" method="GET" class="relative w-full max-w-md">
                        <input type="search" name="search" placeholder="Cari penjahit, kebaya, jas, dress..." class="w-full rounded-2xl border border-tailor-purple/10 bg-white/80 py-3 pl-11 pr-4 text-sm font-medium text-tailor-ink outline-none shadow-sm transition focus:border-tailor-gold focus:ring-4 focus:ring-tailor-gold/20">
                        <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-tailor-purple/45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    </form>
                </div>

                <div class="hidden items-center gap-1 lg:flex">
                    <a href="{{ route('landing') }}" class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }} px-4 py-2 text-sm font-bold">Beranda</a>
                    <a href="{{ route('tailors.index') }}" class="nav-link {{ request()->routeIs('tailors*') ? 'active' : '' }} px-4 py-2 text-sm font-bold">Penjahit</a>
                    <a href="{{ route('portfolios.index') }}" class="nav-link {{ request()->routeIs('portfolios*') ? 'active' : '' }} px-4 py-2 text-sm font-bold">Portfolio</a>
                    <a href="{{ route('price-lists.index') }}" class="nav-link {{ request()->routeIs('price-lists*') ? 'active' : '' }} px-4 py-2 text-sm font-bold">Harga</a>
                </div>

                <div class="hidden shrink-0 items-center gap-3 lg:flex">
                    @auth
                        @if(auth()->user()->role === \App\Enums\UserRole::Customer)
                            <a href="{{ route('customer.orders.index') }}" class="relative rounded-2xl border border-tailor-purple/10 bg-white px-4 py-3 text-sm font-extrabold text-tailor-purple shadow-sm transition hover:border-tailor-gold/50 hover:bg-tailor-cream">
                                Pesanan
                                @if($pendingCount > 0)
                                    <span class="absolute -right-2 -top-2 grid h-5 min-w-5 place-items-center rounded-full bg-tailor-gold px-1 text-[10px] text-tailor-deep">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        @endif
                        <a href="{{ $dashboardRoute }}" class="rounded-2xl brand-gradient px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5">
                            {{ auth()->user()->role === \App\Enums\UserRole::Customer ? 'Dashboard Saya' : 'Dashboard' }}
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm font-extrabold text-red-600 transition hover:bg-red-100">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-2xl px-4 py-3 text-sm font-extrabold text-tailor-purple hover:bg-tailor-soft">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-2xl brand-gradient px-5 py-3 text-sm font-extrabold text-white shadow-soft transition hover:-translate-y-0.5">Mulai Pesan</a>
                    @endauth
                </div>

                <button id="mobile-menu-btn" class="rounded-2xl bg-white p-3 text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10 lg:hidden" aria-label="Buka menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden border-t border-tailor-purple/10 bg-white lg:hidden">
            <div class="mx-auto max-w-7xl space-y-2 px-4 py-4 sm:px-6">
                <form action="{{ route('tailors.index') }}" method="GET" class="relative mb-3">
                    <input type="search" name="search" placeholder="Cari jasa jahit..." class="w-full rounded-2xl border border-tailor-purple/10 bg-tailor-cream py-3 pl-10 pr-4 text-sm outline-none">
                    <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-tailor-purple/45" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                </form>
                <a href="{{ route('landing') }}" class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('landing') ? 'bg-tailor-soft text-tailor-purple' : 'text-slate-600 hover:bg-tailor-cream' }}">Beranda</a>
                <a href="{{ route('tailors.index') }}" class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('tailors*') ? 'bg-tailor-soft text-tailor-purple' : 'text-slate-600 hover:bg-tailor-cream' }}">Penjahit</a>
                <a href="{{ route('portfolios.index') }}" class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('portfolios*') ? 'bg-tailor-soft text-tailor-purple' : 'text-slate-600 hover:bg-tailor-cream' }}">Portfolio</a>
                <a href="{{ route('price-lists.index') }}" class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs('price-lists*') ? 'bg-tailor-soft text-tailor-purple' : 'text-slate-600 hover:bg-tailor-cream' }}">Daftar Harga</a>
                @auth
                    @if(auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a href="{{ route('customer.orders.index') }}" class="block rounded-xl px-4 py-3 text-sm font-bold text-slate-600 hover:bg-tailor-cream">Pesanan Saya</a>
                    @endif
                    <a href="{{ $dashboardRoute }}" class="block rounded-xl bg-tailor-purple px-4 py-3 text-center text-sm font-extrabold text-white">
                        {{ auth()->user()->role === \App\Enums\UserRole::Customer ? 'Dashboard Saya' : 'Dashboard' }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="pt-2">@csrf<button type="submit" class="w-full rounded-xl bg-red-50 px-4 py-3 text-sm font-extrabold text-red-600">Logout</button></form>
                @else
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('login') }}" class="rounded-xl bg-tailor-soft px-4 py-3 text-center text-sm font-extrabold text-tailor-purple">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-xl brand-gradient px-4 py-3 text-center text-sm font-extrabold text-white">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @hasSection('fullwidth')
            @yield('content')
        @else
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        @endif
    </main>

    <footer class="border-t border-tailor-purple/10 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-10 md:grid-cols-[1.3fr_0.7fr_0.7fr]">
                <div>
                    <div class="flex items-center">
                        <img src="{{ asset('storage\images\tailortrack-logo.svg') }}" alt="TailorTrack" class="brand-logo h-14 w-auto max-w-[220px]">
                    </div>
                    <p class="mt-4 max-w-md text-sm leading-7 text-slate-500">Platform jasa jahit custom yang membantu pelanggan menemukan penjahit, mengirim detail pesanan, melacak proses jahitan, dan mengelola pembayaran secara lebih rapi.</p>
                </div>
                <div>
                    <h4 class="font-extrabold text-tailor-deep">Menu</h4>
                    <div class="mt-4 grid gap-3 text-sm font-semibold text-slate-500">
                        <a href="{{ route('tailors.index') }}" class="hover:text-tailor-purple">Cari Penjahit</a>
                        <a href="{{ route('portfolios.index') }}" class="hover:text-tailor-purple">Portfolio</a>
                        <a href="{{ route('price-lists.index') }}" class="hover:text-tailor-purple">Daftar Harga</a>
                    </div>
                </div>
                <div>
                    <h4 class="font-extrabold text-tailor-deep">Akun</h4>
                    <div class="mt-4 grid gap-3 text-sm font-semibold text-slate-500">
                        @guest
                            <a href="{{ route('login') }}" class="hover:text-tailor-purple">Masuk</a>
                            <a href="{{ route('register') }}" class="hover:text-tailor-purple">Daftar</a>
                        @else
                            <a href="{{ $dashboardRoute }}" class="hover:text-tailor-purple">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST">@csrf<button class="text-left hover:text-red-600">Logout</button></form>
                        @endguest
                    </div>
                </div>
            </div>
            <div class="mt-10 flex flex-col items-center justify-between gap-3 border-t border-tailor-purple/10 pt-6 text-xs font-semibold text-slate-400 sm:flex-row">
                <p>&copy; {{ date('Y') }} TailorTrack. Platform Jasa Jahit Terpercaya.</p>
                <p>Needle - Thread - Tracking - Completion</p>
            </div>
        </div>
    </footer>

    <script>
        setTimeout(function () {
            ['flash-success', 'flash-error'].forEach(function (id) {
                const el = document.getElementById(id);
                if (el) { el.style.transition = 'opacity .4s'; el.style.opacity = '0'; setTimeout(() => el.remove(), 400); }
            });
        }, 4000);

        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            if (menu) menu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
