{{-- =========================================
     SIDEBAR TAILOR — navigation partial
     Include: @include('layouts.partials.sidebar-tailor')
     ========================================= --}}

<p class="nav-label">Menu Utama</p>
<a href="{{ route('tailor.dashboard') }}"
   class="nav-link {{ request()->routeIs('tailor.dashboard*') ? 'active' : '' }}">
    <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
    </svg>
    Dashboard
</a>

<p class="nav-label">Toko Saya</p>
<a href="{{ route('tailor.profile.edit') }}"
   class="nav-link {{ request()->routeIs('tailor.profile*') ? 'active' : '' }}">
    <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
    </svg>
    Profil Toko
</a>

<a href="{{ route('tailor.portfolios.index') }}"
   class="nav-link {{ request()->routeIs('tailor.portfolios*') ? 'active' : '' }}">
    <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
    </svg>
    Portfolio
</a>

<p class="nav-label">Pesanan</p>
<a href="{{ route('tailor.orders.index') }}"
   class="nav-link {{ request()->routeIs('tailor.orders*') ? 'active' : '' }}">
    <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z"/>
    </svg>
    Pesanan Masuk
    {{-- Badge notif jika ada pesanan menunggu konfirmasi --}}
    @php
        $pendingCount = auth()->user()?->tailorOrders()
            ->where('status', \App\Enums\OrderStatus::MenungguKonfirmasi->value)
            ->count() ?? 0;
    @endphp
    @if($pendingCount > 0)
        <span class="ml-auto bg-yellow-400 text-yellow-900 text-[10px] font-black px-1.5 py-0.5 rounded-full leading-none min-w-[18px] text-center">
            {{ $pendingCount }}
        </span>
    @endif
</a>

<p class="nav-label">Ulasan</p>
<a href="{{ route('tailor.reviews.index') }}"
   class="nav-link {{ request()->routeIs('tailor.reviews*') ? 'active' : '' }}">
    <svg class="icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557L3.04 10.385a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345l2.125-5.111z"/>
    </svg>
    Rating & Ulasan
    {{-- Badge jumlah ulasan --}}
    @php
        $reviewCount = auth()->user()?->reviewsReceived()->count() ?? 0;
    @endphp
    @if($reviewCount > 0)
        <span class="ml-auto bg-white/20 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none min-w-[18px] text-center">
            {{ $reviewCount }}
        </span>
    @endif
</a>
