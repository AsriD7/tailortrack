@extends('layouts.customer')

@section('title', 'Ukuran Saya')

@section('content')
<div class="space-y-6">
    <section class="rounded-[2rem] bg-tailor-cream p-5 shadow-sm ring-1 ring-tailor-purple/10 sm:p-7">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-black text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">Ukuran Custom</span>
                <h1 class="mt-5 text-3xl font-black text-tailor-deep">Ukuran Saya</h1>
                <p class="mt-2 text-sm leading-7 text-slate-600">Simpan ukuran badan sekali, lalu gunakan ulang saat membuat pesanan custom.</p>
            </div>
            <a href="{{ route('customer.measurements.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl brand-gradient px-5 py-3 text-sm font-extrabold text-white shadow-soft">
                <span class="text-lg leading-none">+</span>
                Tambah Ukuran
            </a>
        </div>
    </section>

    @if($measurements->isEmpty())
        <section class="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-tailor-purple/10">
            <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-tailor-soft text-tailor-purple">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16M8 4v16m8-16v16"/>
                </svg>
            </div>
            <h2 class="mt-5 text-xl font-black text-tailor-deep">Belum ada profil ukuran</h2>
            <p class="mt-2 text-sm leading-7 text-slate-500">Tambahkan ukuran badan agar order custom berikutnya lebih cepat.</p>
        </section>
    @else
        <section class="grid gap-4 md:grid-cols-2">
            @foreach($measurements as $measurement)
                @php $snapshot = $measurement->detailSnapshot(); @endphp
                <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10">
                    <div class="mb-5 flex items-start justify-between gap-3">
                        <div>
                            <h2 class="font-black text-tailor-deep">{{ $measurement->label }}</h2>
                            <p class="mt-1 text-xs font-semibold text-slate-400">
                                {{ $measurement->gender ?: 'Umum' }} - Diperbarui {{ $measurement->updated_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('customer.measurements.edit', $measurement) }}" class="rounded-2xl bg-tailor-soft px-3 py-2 text-xs font-black text-tailor-purple">
                                Edit
                            </a>
                            <form action="{{ route('customer.measurements.destroy', $measurement) }}" method="POST" onsubmit="return confirm('Hapus profil ukuran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-2xl bg-red-50 px-3 py-2 text-xs font-black text-red-600">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        @forelse($snapshot['details'] as $label => $value)
                            <div class="rounded-2xl bg-tailor-cream px-3 py-2">
                                <p class="text-[11px] font-bold text-slate-400">{{ $label }}</p>
                                <p class="mt-0.5 text-sm font-black text-tailor-deep">{{ $value }}</p>
                            </div>
                        @empty
                            <p class="col-span-2 text-sm font-semibold text-slate-500">Belum ada detail angka ukuran.</p>
                        @endforelse
                    </div>

                    @if($measurement->notes)
                        <div class="mt-3 rounded-2xl border border-amber-100 bg-amber-50 px-3 py-2 text-xs font-semibold leading-6 text-amber-800">
                            {{ $measurement->notes }}
                        </div>
                    @endif
                </article>
            @endforeach
        </section>

        {{ $measurements->links() }}
    @endif
</div>
@endsection
