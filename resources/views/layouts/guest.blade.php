<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta-description', 'TailorTrack - Platform pemesanan jasa jahit custom, tracking pesanan, portofolio penjahit, dan pembayaran sederhana.')">
    <meta name="theme-color" content="#4C0D7A">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="TailorTrack">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>@yield('title', 'TailorTrack') - Platform Jasa Jahit Custom</title>
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/tailortrack-icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/tailortrack-icon-192.png') }}">

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
                        soft: '0 18px 45px -18px rgba(76, 13, 122, 0.28)'
                    }
                }
            }
        }
    </script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .brand-gradient { background: linear-gradient(135deg, #4C0D7A 0%, #6D28D9 55%, #2E064F 100%); }
        .brand-text { background: linear-gradient(135deg, #4C0D7A 0%, #6D28D9 65%, #F0B34F 105%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
    </style>

    @stack('styles')
</head>
<body class="min-h-full bg-tailor-cream text-tailor-ink antialiased">
    @if(session('success'))
        <div id="flash-success" class="fixed right-5 top-5 z-50 rounded-2xl border border-emerald-200 bg-white px-5 py-4 text-sm font-semibold text-emerald-700 shadow-soft">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error" class="fixed right-5 top-5 z-50 rounded-2xl border border-red-200 bg-white px-5 py-4 text-sm font-semibold text-red-700 shadow-soft">
            {{ session('error') }}
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <script>
        setTimeout(function() {
            ['flash-success', 'flash-error'].forEach(function(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.style.transition = 'opacity .4s';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 400);
                }
            });
        }, 4000);

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('{{ asset('sw.js') }}', { scope: '{{ asset('/') }}' }).catch(function () {});
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
