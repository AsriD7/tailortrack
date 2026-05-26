<?php

namespace App\Http\Controllers\Tailor;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
use App\Models\TailorUnavailableDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TailorProfileController extends Controller
{
    /**
     * Tampilkan form edit profil penjahit.
     */
    public function edit()
    {
        $user    = Auth::user();
        $profile = $user->tailorProfile;
        $priceLists = PriceList::orderBy('category')->orderBy('name')->get();
        $unavailableDates = $user->unavailableDates()
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();

        $user->load('priceLists');

        return view('tailor.profile.edit', compact('user', 'profile', 'priceLists', 'unavailableDates'));
    }

    /**
     * Update profil penjahit.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'shop_name'        => 'required|string|max:255',
            'specialization'   => 'nullable|string|max:255',
            'description'      => 'nullable|string|max:2000',
            'experience_years' => 'nullable|integer|min:0|max:100',
            'is_available'     => 'nullable|boolean',
            'max_active_orders' => 'nullable|integer|min:1|max:999',
            'max_weekly_orders' => 'nullable|integer|min:1|max:999',
            'estimated_processing_days' => 'nullable|integer|min:1|max:365',
            'working_days'      => 'nullable|array',
            'working_days.*'    => 'integer|min:0|max:6',
            'profile_photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone'            => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:500',
            'price_list_ids'    => 'nullable|array',
            'price_list_ids.*'  => 'exists:price_lists,id',
        ], [
            'shop_name.required'        => 'Nama toko wajib diisi.',
            'profile_photo.image'       => 'Foto profil harus berupa gambar.',
            'profile_photo.max'         => 'Ukuran foto profil maksimal 2MB.',
        ]);

        // Update data user (phone, address)
        $user->update([
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        $profileData = [
            'shop_name'        => $request->shop_name,
            'specialization'   => $request->specialization,
            'description'      => $request->description,
            'experience_years' => $request->experience_years,
            'is_available'     => $request->boolean('is_available', true),
            'max_active_orders' => $request->max_active_orders,
            'max_weekly_orders' => $request->max_weekly_orders,
            'estimated_processing_days' => $request->estimated_processing_days,
            'working_days'      => $request->input('working_days', []),
        ];

        // Upload foto profil baru jika ada
        if ($request->hasFile('profile_photo')) {
            $path                      = $request->file('profile_photo')->store('tailor-profiles', 'public');
            $profileData['profile_photo'] = $path;
        }

        // Buat atau update profil penjahit
        $user->tailorProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        $user->priceLists()->sync($request->input('price_list_ids', []));

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Tambahkan tanggal libur khusus penjahit.
     */
    public function storeUnavailableDate(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:255',
        ], [
            'date.required' => 'Tanggal libur wajib diisi.',
            'date.after_or_equal' => 'Tanggal libur tidak boleh sebelum hari ini.',
            'reason.max' => 'Alasan maksimal 255 karakter.',
        ]);

        TailorUnavailableDate::updateOrCreate(
            [
                'tailor_id' => Auth::id(),
                'date' => $validated['date'],
            ],
            [
                'reason' => $validated['reason'] ?? null,
            ]
        );

        return back()->with('success', 'Tanggal tidak tersedia berhasil ditambahkan.');
    }

    /**
     * Hapus tanggal libur khusus penjahit.
     */
    public function destroyUnavailableDate(TailorUnavailableDate $unavailableDate)
    {
        abort_if($unavailableDate->tailor_id !== Auth::id(), 403);

        $unavailableDate->delete();

        return back()->with('success', 'Tanggal tidak tersedia berhasil dihapus.');
    }
}
