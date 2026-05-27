@extends('layouts.customer')

@section('title', 'Ukuran Saya')
@section('page-title', 'Ukuran Saya')
@section('page-subtitle', 'Simpan profil ukuran agar pesanan custom lebih cepat dibuat')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Ukuran Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Profil ini bisa dipilih saat membuat pesanan dengan ukuran Custom.</p>
        </div>
        <a href="{{ route('customer.measurements.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg gradient-brand text-white text-sm font-semibold hover:opacity-90">
            <span class="text-lg leading-none">+</span>
            Tambah Ukuran
        </a>
    </div>

    @if($measurements->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 mx-auto flex items-center justify-center mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16M8 4v16m8-16v16"/>
                </svg>
            </div>
            <p class="font-bold text-slate-800">Belum ada profil ukuran</p>
            <p class="text-sm text-slate-500 mt-1">Tambahkan ukuran badan sekali, lalu gunakan ulang saat order custom.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($measurements as $measurement)
                @php $snapshot = $measurement->detailSnapshot(); @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div>
                            <h2 class="font-bold text-slate-800">{{ $measurement->label }}</h2>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $measurement->gender ?: 'Umum' }} · Diperbarui {{ $measurement->updated_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('customer.measurements.edit', $measurement) }}"
                               class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200">
                                Edit
                            </a>
                            <form action="{{ route('customer.measurements.destroy', $measurement) }}" method="POST"
                                  onsubmit="return confirm('Hapus profil ukuran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-semibold hover:bg-red-100">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        @forelse($snapshot['details'] as $label => $value)
                            <div class="rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
                                <p class="text-[11px] text-slate-400">{{ $label }}</p>
                                <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $value }}</p>
                            </div>
                        @empty
                            <p class="col-span-2 text-sm text-slate-500">Belum ada detail angka ukuran.</p>
                        @endforelse
                    </div>

                    @if($measurement->notes)
                        <div class="mt-3 rounded-xl bg-amber-50 border border-amber-100 px-3 py-2 text-xs text-amber-800 leading-relaxed">
                            {{ $measurement->notes }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{ $measurements->links() }}
    @endif
</div>
@endsection
