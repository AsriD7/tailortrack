<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TailorTrack - Platform pemesanan jasa jahit terpercaya.">
    <title>@yield('title', 'TailorTrack') - Platform Jasa Jahit</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-brand { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        .nav-link {
            position: relative;
            transition: color 0.15s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            border-radius: 2px 2px 0 0;
            transform: scaleX(0);
            transition: transform 0.2s ease;
        }
        .nav-link:hover::after, .nav-link.active::after { transform: scaleX(1); }
        .nav-link.active { color: #4f46e5; font-weight: 600; }
        .card-hover { transition: all 0.2s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 28px -6px rgba(79,70,229,0.15); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

        /* Mobile nav slide */
        #mobile-menu { transition: all 0.25s ease; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 text-slate-800 antialiased min-h-screen flex flex-col">

    {{-- ================================================================
         FLASH MESSAGES
         ================================================================ --}}
    @if(session('success'))
        <div id="flash-success" class="fixed top-4 right-4 z-[100] flex items-center gap-3 bg-emerald-500 text-white px-5 py-3.5 rounded-2xl shadow-xl text-sm font-medium max-w-sm border border-emerald-400">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-success').remove()" class="ml-auto opacity-70 hover:opacity-100 text-lg leading-none">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div id="flash-error" class="fixed top-4 right-4 z-[100] flex items-center gap-3 bg-red-500 text-white px-5 py-3.5 rounded-2xl shadow-xl text-sm font-medium max-w-sm border border-red-400">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
            <button onclick="document.getElementById('flash-error').remove()" class="ml-auto opacity-70 hover:opacity-100 text-lg leading-none">✕</button>
        </div>
    @endif

    {{-- ================================================================
         TOP NAVIGATION
         ================================================================ --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">

                {{-- Logo --}}
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5 shrink-0">
                    <div class="w-9 h-9 gradient-brand rounded-xl flex items-center justify-center shadow-md shadow-indigo-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">TailorTrack</span>
                        <span class="text-[10px] bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded-full font-bold">2.0</span>
                    </div>
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden md:flex items-center h-full gap-1">
                    <a href="{{ route('customer.dashboard') }}"
                       class="nav-link px-4 h-full flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 {{ request()->routeIs('customer.dashboard*') ? 'active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('tailors.index') }}"
                       class="nav-link px-4 h-full flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 {{ request()->routeIs('tailors*') ? 'active' : '' }}">
                        Cari Penjahit
                    </a>
                    <a href="{{ route('customer.orders.index') }}"
                       class="nav-link px-4 h-full flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 {{ request()->routeIs('customer.orders*') ? 'active' : '' }}">
                        Pesanan Saya
                        @php $pendingCount = auth()->user()->customerOrders()->whereIn('status', ['menunggu_pembayaran', 'menunggu_konfirmasi'])->count() @endphp
                        @if($pendingCount > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('price-lists.index') }}"
                       class="nav-link px-4 h-full flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 {{ request()->routeIs('price-lists*') ? 'active' : '' }}">
                        Daftar Harga
                    </a>
                </div>

                {{-- Right: User + Logout --}}
                <div class="flex items-center gap-3">
                    {{-- User avatar + name --}}
                    <div class="hidden sm:flex items-center gap-3 pr-3 border-r border-gray-100">
                        <div class="w-9 h-9 gradient-brand rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm ring-2 ring-indigo-100">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-gray-400 leading-tight">Pelanggan</p>
                        </div>
                    </div>

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 text-sm font-medium px-3 py-2 rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>

                    {{-- Mobile menu button --}}
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('customer.dashboard*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
                <a href="{{ route('tailors.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('tailors*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Penjahit
                </a>
                <a href="{{ route('customer.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('customer.orders*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
                    Pesanan Saya
                </a>
                <a href="{{ route('price-lists.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('price-lists*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/></svg>
                    Daftar Harga
                </a>
            </div>
        </div>
    </nav>

    {{-- ================================================================
         PAGE CONTENT
         ================================================================ --}}
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </div>
    </main>

    {{-- ================================================================
         FOOTER
         ================================================================ --}}
    <footer class="border-t border-gray-100 bg-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-400">
            <p>© {{ date('Y') }} <span class="font-semibold text-indigo-600">TailorTrack</span> — Platform Jasa Jahit Terpercaya</p>
            <div class="flex gap-4">
                <a href="{{ route('tailors.index') }}" class="hover:text-indigo-600 transition-colors">Cari Penjahit</a>
                <a href="{{ route('price-lists.index') }}" class="hover:text-indigo-600 transition-colors">Daftar Harga</a>
            </div>
        </div>
    </footer>

    <script>
        // Auto-dismiss flash messages
        setTimeout(function() {
            ['flash-success', 'flash-error'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) {
                    el.style.transition = 'opacity 0.4s';
                    el.style.opacity = '0';
                    setTimeout(function() { el.remove(); }, 400);
                }
            });
        }, 4000);

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
