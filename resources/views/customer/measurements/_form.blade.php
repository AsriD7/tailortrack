@csrf

<div class="rounded-[2rem] bg-white p-5 shadow-sm ring-1 ring-tailor-purple/10 sm:p-7">
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="label" class="mb-2 block text-sm font-black text-tailor-deep">Nama Profil</label>
            <input type="text" id="label" name="label" value="{{ old('label', $measurement->label) }}"
                   placeholder="Contoh: Ukuran Saya, Anak, Ayah"
                   class="h-12 w-full rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-4 text-sm font-semibold outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20 @error('label') border-red-300 bg-red-50 @enderror">
            @error('label') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="gender" class="mb-2 block text-sm font-black text-tailor-deep">Tipe Ukuran</label>
            <select id="gender" name="gender" class="h-12 w-full rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-4 text-sm font-semibold outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20">
                <option value="">Umum</option>
                <option value="Pria" @selected(old('gender', $measurement->gender) === 'Pria')>Pria</option>
                <option value="Wanita" @selected(old('gender', $measurement->gender) === 'Wanita')>Wanita</option>
                <option value="Anak" @selected(old('gender', $measurement->gender) === 'Anak')>Anak</option>
            </select>
        </div>
    </div>

    @php
        $fields = [
            'height_cm' => ['Tinggi Badan', 'cm'],
            'weight_kg' => ['Berat Badan', 'kg'],
            'chest_cm' => ['Lingkar Dada', 'cm'],
            'waist_cm' => ['Lingkar Pinggang', 'cm'],
            'hip_cm' => ['Lingkar Pinggul', 'cm'],
            'shoulder_cm' => ['Lebar Bahu', 'cm'],
            'sleeve_length_cm' => ['Panjang Lengan', 'cm'],
            'shirt_length_cm' => ['Panjang Baju', 'cm'],
            'pants_length_cm' => ['Panjang Celana/Rok', 'cm'],
            'thigh_cm' => ['Lingkar Paha', 'cm'],
        ];
    @endphp

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($fields as $field => [$label, $unit])
            <div>
                <label for="{{ $field }}" class="mb-2 block text-sm font-black text-tailor-deep">{{ $label }}</label>
                <div class="relative">
                    <input type="number" step="0.1" min="1" max="300" id="{{ $field }}" name="{{ $field }}"
                           value="{{ old($field, $measurement->{$field}) }}"
                           class="h-12 w-full rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-4 pr-12 text-sm font-semibold outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20 @error($field) border-red-300 bg-red-50 @enderror">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">{{ $unit }}</span>
                </div>
                @error($field) <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        <label for="notes" class="mb-2 block text-sm font-black text-tailor-deep">Catatan Ukuran</label>
        <textarea id="notes" name="notes" rows="3" maxlength="500"
                  placeholder="Contoh: bahu agak turun, celana dibuat longgar, panjang lengan sampai pergelangan..."
                  class="w-full rounded-2xl border border-tailor-purple/10 bg-tailor-cream px-4 py-3 text-sm font-semibold outline-none transition focus:border-tailor-gold focus:bg-white focus:ring-4 focus:ring-tailor-gold/20 @error('notes') border-red-300 bg-red-50 @enderror">{{ old('notes', $measurement->notes) }}</textarea>
        @error('notes') <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex items-center justify-between gap-4">
    <a href="{{ route('customer.measurements.index') }}" class="rounded-2xl bg-slate-100 px-5 py-3 text-sm font-extrabold text-slate-600">
        Batal
    </a>
    <button type="submit" class="rounded-2xl brand-gradient px-6 py-3 text-sm font-extrabold text-white shadow-soft">
        Simpan Ukuran
    </button>
</div>
