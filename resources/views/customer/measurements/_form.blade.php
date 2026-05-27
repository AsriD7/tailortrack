@csrf

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="label" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Profil <span class="text-red-500">*</span></label>
            <input type="text" id="label" name="label" value="{{ old('label', $measurement->label) }}"
                   placeholder="Contoh: Ukuran Saya, Anak, Ayah"
                   class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('label') border-red-400 @enderror">
            @error('label') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="gender" class="block text-sm font-semibold text-slate-700 mb-1.5">Tipe Ukuran</label>
            <select id="gender" name="gender"
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
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

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($fields as $field => [$label, $unit])
            <div>
                <label for="{{ $field }}" class="block text-sm font-semibold text-slate-700 mb-1.5">{{ $label }}</label>
                <div class="relative">
                    <input type="number" step="0.1" min="1" max="300" id="{{ $field }}" name="{{ $field }}"
                           value="{{ old($field, $measurement->{$field}) }}"
                           class="w-full px-4 py-2.5 pr-12 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 @error($field) border-red-400 @enderror">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400">{{ $unit }}</span>
                </div>
                @error($field) <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        @endforeach
    </div>

    <div>
        <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan Ukuran</label>
        <textarea id="notes" name="notes" rows="3" maxlength="500"
                  placeholder="Contoh: bahu agak turun, celana dibuat longgar, panjang lengan sampai pergelangan..."
                  class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none @error('notes') border-red-400 @enderror">{{ old('notes', $measurement->notes) }}</textarea>
        @error('notes') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="flex items-center justify-between gap-4 mt-6">
    <a href="{{ route('customer.measurements.index') }}"
       class="px-5 py-2.5 rounded-lg bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200">
        Batal
    </a>
    <button type="submit" class="px-6 py-2.5 rounded-lg gradient-brand text-white text-sm font-semibold hover:opacity-90">
        Simpan Ukuran
    </button>
</div>
