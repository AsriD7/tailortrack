<?php

namespace App\Http\Controllers\Tailor;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
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

        $user->load('priceLists');

        return view('tailor.profile.edit', compact('user', 'profile', 'priceLists'));
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
}
