<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta-description', 'TailorTrack - Platform pemesanan jasa jahit terpercaya.')">
    <title>@yield('title', 'TailorTrack') - Platform Jasa Jahit</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: {
                            50:  '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-brand { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
        .gradient-text {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.6);
        }
        .card-hover {
            transition: all 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(79, 70, 229, 0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
        }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-white text-slate-800 antialiased">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-success" class="fixed top-4 right-4 z-50 flex items-center gap-3 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium max-w-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Navbar --}}
    <nav class="sticky top-0 z-40 glass shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                {{-- Logo --}}
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 gradient-brand rounded-lg flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-lg gradient-text">TailorTrack</span>
                </a>

                {{-- Nav Links --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('landing') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Beranda</a>
                    <a href="{{ route('tailors.index') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Penjahit</a>
                    <a href="{{ route('price-lists.index') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Daftar Harga</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="flex items-center gap-3">
                    @auth
                        @php
                            $dashRoute = match(auth()->user()->role) {
                                \App\Enums\UserRole::Admin    => route('admin.dashboard'),
                                \App\Enums\UserRole::Tailor   => route('tailor.dashboard'),
                                \App\Enums\UserRole::Customer => route('customer.dashboard'),
                            };
                        @endphp
                        <a href="{{ $dashRoute }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Dashboard →</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary px-4 py-2 rounded-lg text-sm font-semibold">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-8 h-8 gradient-brand rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-lg">TailorTrack</span>
                    </div>
                    <p class="text-slate-400 text-sm">Platform marketplace jasa jahit terpercaya. Menghubungkan customer dengan penjahit profesional.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-slate-200">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('tailors.index') }}" class="hover:text-white transition-colors">Daftar Penjahit</a></li>
                        <li><a href="{{ route('price-lists.index') }}" class="hover:text-white transition-colors">Daftar Harga</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Daftar sebagai Customer</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4 text-slate-200">Kontak</h4>
                    <p class="text-slate-400 text-sm">Email: hello@tailortrack.com</p>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-8 pt-6 text-center text-sm text-slate-500">
                © {{ date('Y') }} TailorTrack. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
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
    </script>

    @stack('scripts')
</body>
</html>
