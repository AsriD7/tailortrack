@extends('layouts.app')

@section('title', 'Moderasi Review')
@section('page-title', 'Moderasi Review')
@section('page-subtitle', 'Pantau dan hapus ulasan yang tidak layak tampil')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.dashboard*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('admin.tailors.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.tailors*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"/>
        </svg>
        Penjahit
    </a>
    <a href="{{ route('admin.users.index', ['role' => 'customer']) }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.users*') && request('role') === 'customer' ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Customer
    </a>
    <a href="{{ route('admin.price-lists.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.price-lists*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
        </svg>
        Daftar Harga
    </a>
    <a href="{{ route('admin.orders.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.orders*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
        </svg>
        Semua Pesanan
    </a>
    <a href="{{ route('admin.payments.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:text-white text-sm font-medium {{ request()->routeIs('admin.payments*') ? 'active bg-white/15 text-white' : '' }}">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
        </svg>
        Pembayaran
    </a>
    <a href="{{ route('admin.reviews.index') }}"
       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-white text-sm font-medium active bg-white/15">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557L3.04 10.385a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345l2.125-5.111z"/>
        </svg>
        Review
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow-soft border border-tailor-purple/10">
            <p class="text-xs text-slate-500 font-medium">Total Review</p>
            <p class="text-2xl font-bold text-slate-800 mt-2">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-soft border border-tailor-purple/10">
            <p class="text-xs text-slate-500 font-medium">Rata-rata Rating</p>
            <p class="text-2xl font-bold text-yellow-600 mt-2">{{ $stats['average'] ?: '-' }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-soft border border-tailor-purple/10">
            <p class="text-xs text-slate-500 font-medium">Rating Rendah</p>
            <p class="text-2xl font-bold text-red-600 mt-2">{{ number_format($stats['low_rating']) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-soft border border-tailor-purple/10">
            <p class="text-xs text-slate-500 font-medium">Dengan Komentar</p>
            <p class="text-2xl font-bold text-tailor-purple mt-2">{{ number_format($stats['with_comment']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 p-4 mb-6">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="flex flex-col lg:flex-row gap-3">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari komentar, customer, penjahit, atau kode order..."
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-tailor-gold focus:border-transparent"
                >
            </div>
            <select name="rating" class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-tailor-gold">
                <option value="">Semua Rating</option>
                @for($rating = 5; $rating >= 1; $rating--)
                    <option value="{{ $rating }}" {{ (string) request('rating') === (string) $rating ? 'selected' : '' }}>
                        {{ $rating }} Bintang
                    </option>
                @endfor
            </select>
            <button type="submit" class="brand-gradient text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:opacity-90">
                Filter
            </button>
            @if(request()->hasAny(['search', 'rating']))
                <a href="{{ route('admin.reviews.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-semibold hover:bg-slate-200 text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-tailor-purple/10 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800">
                Daftar Review
                <span class="ml-2 text-sm font-normal text-slate-500">({{ $reviews->total() }} total)</span>
            </h2>
        </div>

        @if($reviews->isEmpty())
            <div class="text-center py-16 px-6">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557L3.04 10.385a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345l2.125-5.111z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-600">Review tidak ditemukan</p>
                <p class="text-xs text-slate-400 mt-1">Coba ubah filter pencarian.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Review</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Penjahit</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Pesanan</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($reviews as $review)
                            <tr class="hover:bg-slate-50/60 transition-colors align-top">
                                <td class="px-6 py-4 min-w-[280px]">
                                    <div class="flex items-center gap-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                        <span class="ml-1 text-xs font-semibold text-yellow-600">{{ $review->rating_label }}</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-slate-700 leading-relaxed">{{ $review->comment }}</p>
                                    @else
                                        <p class="text-slate-400 italic">Tanpa komentar</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-slate-800">{{ $review->customer->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">{{ $review->customer->email ?? '' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-slate-800">{{ $review->tailor->tailorProfile->shop_name ?? $review->tailor->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">{{ $review->tailor->name ?? '' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($review->order)
                                        <a href="{{ route('admin.orders.show', $review->order) }}" class="font-mono text-xs bg-tailor-soft text-tailor-purple px-2.5 py-1 rounded-lg font-semibold hover:bg-tailor-soft">
                                            {{ $review->order->order_code }}
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                    {{ $review->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                                          onsubmit="return confirm('Hapus review ini? Review yang dihapus tidak akan tampil di profil penjahit.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-100 text-red-700 text-xs font-semibold hover:bg-red-200 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($reviews->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $reviews->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
