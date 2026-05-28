<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TailorTrack - Platform pemesanan jasa jahit custom dengan tracking pesanan.">
    <title>@yield('title', 'TailorTrack') - Platform Jasa Jahit</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/tailortrack-icon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
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
        #sidebar { transition: transform .24s cubic-bezier(.4, 0, .2, 1); }
        #sidebar-overlay { transition: opacity .24s ease; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            border-radius: 1rem;
            padding: .7rem .85rem;
            color: rgba(255,255,255,.72);
            font-size: .85rem;
            font-weight: 800;
            transition: background .16s ease, color .16s ease;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,.14);
            color: #fff;
        }
        .nav-link .icon {
            height: 1.1rem;
            width: 1.1rem;
            flex-shrink: 0;
        }
        .nav-label {
            padding: 1rem .85rem .35rem;
            color: rgba(255,255,255,.42);
            font-size: .66rem;
            font-weight: 900;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .card-hover { transition: transform .18s ease, box-shadow .18s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 18px 45px -24px rgba(76,13,122,.35); }
        ::-webkit-scrollbar { width: 7px; height: 7px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d7b7f1; border-radius: 999px; }
    </style>

    @stack('styles')
</head>
<body class="h-full bg-tailor-cream text-tailor-ink antialiased">
@if(session('success'))
    <div id="flash-success" class="fixed right-4 top-4 z-[100] max-w-sm rounded-2xl border border-emerald-200 bg-white px-5 py-4 text-sm font-semibold text-emerald-700 shadow-soft">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="flash-error" class="fixed right-4 top-4 z-[100] max-w-sm rounded-2xl border border-red-200 bg-white px-5 py-4 text-sm font-semibold text-red-700 shadow-soft">
        {{ session('error') }}
    </div>
@endif

<div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-tailor-deep/60 opacity-0 backdrop-blur-sm lg:hidden" onclick="closeSidebar()"></div>

<div class="flex min-h-screen">
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col bg-tailor-deep shadow-2xl lg:relative lg:z-auto lg:translate-x-0">
        <div class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
            <a href="{{ route('landing') }}" class="grid h-12 w-12 place-items-center overflow-hidden rounded-2xl bg-white shadow-soft">
                <img src="{{ asset('storage/images/tailortrack-icon.svg') }}" alt="TailorTrack" class="h-full w-full object-cover">
            </a>
            <div class="min-w-0 flex-1">
                <p class="text-lg font-black leading-none text-white">TailorTrack</p>
                <p class="mt-1 text-xs font-semibold text-white/50">{{ Auth::user()->role->label() }}</p>
            </div>
            <button onclick="closeSidebar()" class="grid h-9 w-9 place-items-center rounded-xl text-white/70 hover:bg-white/10 hover:text-white lg:hidden" aria-label="Tutup menu">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="mx-4 mt-4 rounded-3xl border border-white/10 bg-white/10 p-4">
            <div class="flex items-center gap-3">
                <div class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-white/20 text-sm font-black text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-black text-white">{{ Auth::user()->name }}</p>
                    <p class="mt-1 truncate text-xs font-semibold text-white/55">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-4">
            @if(Auth::user()->isAdmin())
                @include('layouts.partials.sidebar-admin')
            @elseif(Auth::user()->isTailor())
                @include('layouts.partials.sidebar-tailor')
            @else
                @yield('sidebar-nav')
            @endif
        </nav>

        <div class="border-t border-white/10 p-4">
            <a href="{{ route('landing') }}" class="nav-link">
                <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zM3.6 9h16.8M3.6 15h16.8M12 3a14 14 0 010 18M12 3a14 14 0 000 18"/>
                </svg>
                Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-1">
                @csrf
                <button type="submit" class="nav-link w-full text-left">
                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-20 border-b border-tailor-purple/10 bg-white/90 px-4 py-3.5 shadow-sm backdrop-blur lg:px-6">
            <div class="flex items-center gap-4">
                <button onclick="openSidebar()" class="grid h-11 w-11 place-items-center rounded-2xl bg-tailor-cream text-tailor-purple ring-1 ring-tailor-purple/10 lg:hidden" aria-label="Buka menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="min-w-0 flex-1">
                    <h1 class="truncate text-lg font-black text-tailor-deep">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                        <p class="mt-0.5 truncate text-xs font-semibold text-slate-500">@yield('page-subtitle')</p>
                    @endif
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    @yield('page-actions')
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 lg:p-6">
            @yield('content')
        </main>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

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
        setTimeout(() => overlay.classList.add('hidden'), 240);
        document.body.style.overflow = '';
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) closeSidebar();
    });

    setTimeout(function() {
        ['flash-success', 'flash-error'].forEach(function(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity .4s, transform .4s';
                el.style.opacity = '0';
                el.style.transform = 'translateX(120%)';
                setTimeout(() => el.remove(), 420);
            }
        });
    }, 4000);
</script>

@stack('scripts')
</body>
</html>
