@php
    $measurement = $order->measurement_snapshot;
@endphp

@if($measurement)
    <div class="{{ $wrapperClass ?? 'sm:col-span-2' }}">
        <p class="{{ $labelClass ?? 'text-xs font-medium text-slate-400 mb-1' }}">Detail Ukuran</p>
        <div class="rounded-xl bg-indigo-50 border border-indigo-100 p-4">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="text-sm font-bold text-indigo-800">{{ $measurement['label'] ?? $order->size }}</span>
                @if(($measurement['type'] ?? null) === 'custom_profile')
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white text-indigo-600 border border-indigo-100">Profil tersimpan</span>
                @elseif(($measurement['type'] ?? null) === 'custom_manual')
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white text-indigo-600 border border-indigo-100">Manual</span>
                @else
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-white text-indigo-600 border border-indigo-100">Standar</span>
                @endif
            </div>

            @if(!empty($measurement['details']))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach($measurement['details'] as $label => $value)
                        <div class="rounded-lg bg-white/80 border border-indigo-100 px-3 py-2">
                            <p class="text-[11px] font-semibold text-indigo-500">{{ $label }}</p>
                            <p class="text-sm font-bold text-indigo-800 mt-0.5">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            @if(!empty($measurement['notes']))
                <p class="text-xs text-indigo-700 leading-relaxed mt-3">{{ $measurement['notes'] }}</p>
            @endif
        </div>
    </div>
@endif
