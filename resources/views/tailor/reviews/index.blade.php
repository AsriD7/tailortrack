@extends('layouts.app')

@section('title', 'Rating & Ulasan Saya')
@section('page-title', 'Rating & Ulasan')
@section('page-subtitle', 'Semua ulasan yang diberikan pelanggan kepada Anda')

@section('content')
<div class="space-y-6">

    {{-- ── Stats Header ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        {{-- Avg Rating Card --}}
        <div class="bg-gradient-to-br from-yellow-400 to-orange-400 rounded-2xl p-6 text-white shadow-lg shadow-yellow-200/50 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="absolute -right-2 -bottom-6 w-14 h-14 bg-white/10 rounded-full"></div>
            <div class="relative">
                <p class="text-white/80 text-xs font-semibold uppercase tracking-wide mb-2">Rating Rata-rata</p>
                <p class="text-5xl font-black leading-none mb-1">
                    {{ $avgRating ? number_format($avgRating, 1) : '—' }}
                </p>
                <div class="flex items-center gap-0.5 mt-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $avgRating && $i <= round($avgRating) ? 'text-white' : 'text-white/30' }}"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-white/70 text-xs mt-1">dari 5 bintang</p>
            </div>
        </div>

        {{-- Total Reviews --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide">Total Ulasan</p>
                <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-slate-800">{{ $totalReviews }}</p>
            <p class="text-slate-400 text-xs mt-1">ulasan masuk</p>
        </div>

        {{-- Rating Breakdown --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-4">Distribusi Rating</p>
            <div class="space-y-2">
                @foreach($breakdown as $star => $data)
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-500 w-2 text-right shrink-0">{{ $star }}</span>
                    <svg class="w-3.5 h-3.5 text-yellow-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-yellow-400 h-2 rounded-full transition-all duration-500"
                             style="width: {{ $data['percent'] }}%"></div>
                    </div>
                    <span class="text-xs text-slate-400 w-5 text-right shrink-0">{{ $data['count'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Review List ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800">Daftar Ulasan</h2>
                <p class="text-slate-400 text-xs mt-0.5">Ulasan terbaru dari pelanggan Anda</p>
            </div>
        </div>

        @if($reviews->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center px-6">
                <div class="w-20 h-20 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Ulasan</h3>
                <p class="text-slate-400 text-sm max-w-xs">Ulasan dari pelanggan akan muncul di sini setelah pesanan selesai.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($reviews as $review)
                <div class="p-6 hover:bg-slate-50/60 transition-colors">
                    <div class="flex items-start gap-4">
                        {{-- Avatar --}}
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                            {{ strtoupper(substr($review->customer->name ?? 'C', 0, 1)) }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $review->customer->name ?? 'Pelanggan' }}</p>
                                    <p class="text-slate-400 text-xs">{{ $review->created_at->translatedFormat('d F Y') }} · {{ $review->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center gap-1 shrink-0">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-200' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-1 text-xs font-bold text-yellow-600">{{ $review->rating_label }}</span>
                                </div>
                            </div>

                            {{-- Order reference --}}
                            @if($review->order)
                                <div class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 text-xs font-semibold px-2.5 py-1 rounded-lg mb-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    {{ $review->order->order_code }}
                                    @if($review->order->item_name)
                                        · {{ $review->order->item_name }}
                                    @endif
                                </div>
                            @endif

                            {{-- Comment --}}
                            @if($review->comment)
                                <div class="bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                                    <p class="text-sm text-slate-700 leading-relaxed">"{{ $review->comment }}"</p>
                                </div>
                            @else
                                <p class="text-sm text-slate-400 italic">Tidak ada komentar tambahan.</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($reviews->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $reviews->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
