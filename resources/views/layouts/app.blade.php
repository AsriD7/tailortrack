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
                            50:  '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe',
                            300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1',
                            600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Brand gradient */
        .gradient-brand { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }

        /* Sidebar transition */
        #sidebar {
            transition: transform 0.28s cubic-bezier(.4,0,.2,1);
        }

        /* Sidebar overlay */
        #sidebar-overlay {
            transition: opacity 0.28s ease;
        }

        /* Nav link base */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 0.8125rem;
            font-weight: 600;
            color: rgba(255,255,255,0.72);
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
            white-space: nowrap;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
        }
        .nav-link.active {
            background: rgba(255,255,255,0.18);
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.15);
        }
        .nav-link .icon {
            width: 18px; height: 18px;
            flex-shrink: 0;
            opacity: 0.85;
        }
        .nav-link.active .icon { opacity: 1; }

        /* Divider label */
        .nav-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            padding: 12px 12px 4px;
        }

        /* Card hover */
        .card-hover { transition: all 0.2s ease; }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(79,70,229,0.15);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
        .main-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; }

        /* Flash message slide-in */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        .flash-msg { animation: slideInRight 0.35s ease; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased">

{{-- ============================================================
     FLASH MESSAGES
     ============================================================ --}}
@if(session('success'))
    <div id="flash-success"
         class="flash-msg fixed top-4 right-4 z-[100] flex items-center gap-3 bg-emerald-500 text-white pl-4 pr-3 py-3 rounded-2xl shadow-xl shadow-emerald-200/50 text-sm font-semibold max-w-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="flex-1">{{ session('success') }}</span>
        <button onclick="this.closest('#flash-success').remove()"
                class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-white/20 transition-colors text-lg leading-none">×</button>
    </div>
@endif
@if(session('error'))
    <div id="flash-error"
         class="flash-msg fixed top-4 right-4 z-[100] flex items-center gap-3 bg-red-500 text-white pl-4 pr-3 py-3 rounded-2xl shadow-xl shadow-red-200/50 text-sm font-semibold max-w-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="flex-1">{{ session('error') }}</span>
        <button onclick="this.closest('#flash-error').remove()"
                class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-white/20 transition-colors text-lg leading-none">×</button>
    </div>
@endif

{{-- ============================================================
     MOBILE OVERLAY (backdrop saat sidebar terbuka di HP)
     ============================================================ --}}
<div id="sidebar-overlay"
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px] z-30 hidden opacity-0 lg:hidden"
     onclick="closeSidebar()">
</div>

{{-- ============================================================
     WRAPPER
     ============================================================ --}}
<div class="flex h-full min-h-screen">

    {{-- ============================================================
         SIDEBAR
         ============================================================ --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-40 w-64 gradient-brand flex flex-col shadow-2xl shadow-indigo-900/40
                  -translate-x-full lg:translate-x-0 lg:relative lg:z-auto lg:shadow-xl">

        {{-- ─── Logo ─── --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10 flex-shrink-0">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center shadow-inner flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="font-extrabold text-white text-base leading-none tracking-tight">TailorTrack</p>
                <p class="text-white/50 text-[11px] mt-0.5 font-medium">v2.0 — Platform Jahit</p>
            </div>
            {{-- Close button (mobile only) --}}
            <button onclick="closeSidebar()"
                    class="ml-auto lg:hidden w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/15 text-white/70 hover:text-white transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- ─── User Card ─── --}}
        <div class="mx-3 mt-4 mb-2 bg-white/10 rounded-2xl px-4 py-3.5 flex-shrink-0 border border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/25 rounded-xl flex items-center justify-center text-white font-black text-sm flex-shrink-0 shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-bold truncate leading-tight">{{ Auth::user()->name }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>
                        <p class="text-white/60 text-[11px] font-medium">{{ Auth::user()->role->label() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── Navigation ─── --}}
        <nav class="flex-1 px-3 py-2 space-y-0.5 overflow-y-auto">
            @if(Auth::user()->isAdmin())
                @include('layouts.partials.sidebar-admin')
            @elseif(Auth::user()->isTailor())
                @include('layouts.partials.sidebar-tailor')
            @else
                @yield('sidebar-nav')
            @endif
        </nav>

        {{-- ─── Footer (Logout) ─── --}}
        <div class="px-3 pb-4 pt-2 border-t border-white/10 flex-shrink-0 space-y-1">
            {{-- Visit site --}}
            <a href="{{ route('landing') }}" target="_blank"
               class="nav-link">
                <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253"/>
                </svg>
                Lihat Website
            </a>
            {{-- Logout --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link w-full text-left">
                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ============================================================
         MAIN CONTENT
         ============================================================ --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- ─── Top Bar ─── --}}
        <header class="bg-white border-b border-slate-100 px-4 lg:px-6 py-3.5 flex items-center gap-4 shadow-sm flex-shrink-0 sticky top-0 z-20">

            {{-- Hamburger (mobile) --}}
            <button id="sidebar-toggle"
                    onclick="openSidebar()"
                    class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-600 hover:text-slate-800 transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page Title --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-base font-bold text-slate-800 truncate leading-tight">
                    @yield('page-title', 'Dashboard')
                </h1>
                @hasSection('page-subtitle')
                <p class="text-xs text-slate-400 mt-0.5 truncate">@yield('page-subtitle')</p>
                @endif
            </div>

            {{-- Page Actions --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                @yield('page-actions')
            </div>
        </header>

        {{-- ─── Page Content ─── --}}
        <main class="flex-1 overflow-y-auto main-scroll p-4 lg:p-6">
            @yield('content')
        </main>

    </div>{{-- end main --}}

</div>{{-- end wrapper --}}

{{-- ============================================================
     JAVASCRIPT
     ============================================================ --}}
<script>
    // ── Sidebar mobile toggle ──────────────────────────────────
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden', 'opacity-0');
        setTimeout(() => overlay.classList.add('opacity-100'), 10);
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 280);
        document.body.style.overflow = '';
    }

    // Close sidebar on resize to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            closeSidebar();
        }
    });

    // ── Auto-dismiss flash messages ────────────────────────────
    setTimeout(function() {
        ['flash-success', 'flash-error'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity 0.4s, transform 0.4s';
                el.style.opacity = '0';
                el.style.transform = 'translateX(120%)';
                setTimeout(function() { if (el) el.remove(); }, 420);
            }
        });
    }, 4000);
</script>

@stack('scripts')
</body>
</html>
