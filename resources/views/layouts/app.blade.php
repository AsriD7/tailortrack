<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TailorTrack - Platform pemesanan jasa jahit terpercaya. Temukan penjahit profesional di sekitar Anda.">
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
                    colors: {
                        primary: {
                            50:  '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-brand {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }
        .card-hover {
            transition: all 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.15);
        }
        .sidebar-link {
            transition: all 0.15s ease;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255,255,255,0.12);
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-slate-50 text-slate-800">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-success" class="fixed top-4 right-4 z-50 flex items-center gap-3 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium max-w-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-success').remove()" class="ml-auto opacity-70 hover:opacity-100">✕</button>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error" class="fixed top-4 right-4 z-50 flex items-center gap-3 bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium max-w-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
            <button onclick="document.getElementById('flash-error').remove()" class="ml-auto opacity-70 hover:opacity-100">✕</button>
        </div>
    @endif

    <div class="flex h-full min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 flex-shrink-0 gradient-brand flex flex-col shadow-xl">
            {{-- Logo --}}
            <div class="px-6 py-6 border-b border-white/10">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243zm0 0L9.121 9.121"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-white text-lg leading-none">TailorTrack</p>
                        <p class="text-white/60 text-xs">2.0</p>
                    </div>
                </a>
            </div>

            {{-- User Info --}}
            <div class="px-6 py-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-white/60 text-xs">{{ Auth::user()->role->label() }}</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                @yield('sidebar-nav')
            </nav>

            {{-- Logout --}}
            <div class="px-3 py-4 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/70 hover:text-white text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            {{-- Top Bar --}}
            <header class="bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between shadow-sm">
                <div>
                    <h1 class="text-lg font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-500 mt-0.5">@yield('page-subtitle', '')</p>
                </div>
                <div class="flex items-center gap-3">
                    @yield('page-actions')
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>

    </div>

    <script>
        // Auto-dismiss flash messages setelah 4 detik
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
