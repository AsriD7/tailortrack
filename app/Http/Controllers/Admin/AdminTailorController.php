<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\PriceList;
use App\Models\TailorProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminTailorController extends Controller
{
    /**
     * Tampilkan semua akun penjahit.
     */
    public function index(Request $request)
    {
        $query = User::where('role', UserRole::Tailor->value)->with('tailorProfile');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhereHas('tailorProfile', fn($p) => $p->where('shop_name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->filled('published')) {
            $query->whereHas('tailorProfile', fn($p) => $p->where('is_verified', $request->published));
        }

        $tailors = $query->latest()->paginate(15);

        return view('admin.tailors.index', compact('tailors'));
    }

    /**
     * Tampilkan form tambah penjahit baru.
     */
    public function create()
    {
        $priceLists = PriceList::orderBy('category')->orderBy('name')->get();

        return view('admin.tailors.create', compact('priceLists'));
    }

    /**
     * Simpan penjahit baru beserta profil awalnya.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users,email',
            'password'       => 'required|string|min:8',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:500',
            'shop_name'      => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:2000',
            'max_active_orders' => 'nullable|integer|min:1|max:999',
            'max_weekly_orders' => 'nullable|integer|min:1|max:999',
            'estimated_processing_days' => 'nullable|integer|min:1|max:365',
            'working_days' => 'nullable|array',
            'working_days.*' => 'integer|min:0|max:6',
            'price_list_ids' => 'nullable|array',
            'price_list_ids.*' => 'exists:price_lists,id',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'shop_name.required' => 'Nama toko wajib diisi.',
        ]);

        // Buat user penjahit
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => UserRole::Tailor,
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        // Buat profil penjahit otomatis
        TailorProfile::create([
            'user_id'        => $user->id,
            'shop_name'      => $request->shop_name,
            'specialization' => $request->specialization,
            'description'    => $request->description,
            'max_active_orders' => $request->max_active_orders,
            'max_weekly_orders' => $request->max_weekly_orders,
            'estimated_processing_days' => $request->estimated_processing_days,
            'working_days' => $request->input('working_days', []),
            'is_verified'    => true,
            'is_available'   => true,
        ]);

        $user->priceLists()->sync($request->input('price_list_ids', []));

        return redirect()->route('admin.tailors.index')
            ->with('success', "Akun penjahit {$user->name} berhasil dibuat.");
    }

    /**
     * Tampilkan detail penjahit.
     */
    public function show(User $tailor)
    {
        abort_if($tailor->role !== UserRole::Tailor, 404);

        $tailor->load(['tailorProfile', 'portfolios', 'priceLists', 'tailorOrders' => fn($q) => $q->limit(5)->latest()]);

        return view('admin.tailors.show', compact('tailor'));
    }

    /**
     * Tampilkan form edit penjahit.
     */
    public function edit(User $tailor)
    {
        abort_if($tailor->role !== UserRole::Tailor, 404);

        $tailor->load(['tailorProfile', 'priceLists']);
        $priceLists = PriceList::orderBy('category')->orderBy('name')->get();

        return view('admin.tailors.edit', compact('tailor', 'priceLists'));
    }

    /**
     * Update data penjahit.
     */
    public function update(Request $request, User $tailor)
    {
        abort_if($tailor->role !== UserRole::Tailor, 404);

        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users,email,' . $tailor->id,
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:500',
            'shop_name'      => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:2000',
            'is_available'   => 'nullable|boolean',
            'max_active_orders' => 'nullable|integer|min:1|max:999',
            'max_weekly_orders' => 'nullable|integer|min:1|max:999',
            'estimated_processing_days' => 'nullable|integer|min:1|max:365',
            'working_days' => 'nullable|array',
            'working_days.*' => 'integer|min:0|max:6',
            'price_list_ids'  => 'nullable|array',
            'price_list_ids.*' => 'exists:price_lists,id',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email ini sudah digunakan.',
            'shop_name.required' => 'Nama toko wajib diisi.',
        ]);

        $tailor->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        $tailor->tailorProfile()->updateOrCreate(
            ['user_id' => $tailor->id],
            [
                'shop_name'      => $request->shop_name,
                'specialization' => $request->specialization,
                'description'    => $request->description,
                'is_available'   => $request->boolean('is_available', true),
                'max_active_orders' => $request->max_active_orders,
                'max_weekly_orders' => $request->max_weekly_orders,
                'estimated_processing_days' => $request->estimated_processing_days,
                'working_days' => $request->input('working_days', []),
            ]
        );

        $tailor->priceLists()->sync($request->input('price_list_ids', []));

        return redirect()->route('admin.tailors.show', $tailor)
            ->with('success', 'Data penjahit berhasil diperbarui.');
    }

    /**
     * Admin mengatur apakah profil penjahit tampil di publik.
     */
    public function verify(User $tailor)
    {
        abort_if($tailor->role !== UserRole::Tailor, 404);

        $profile = $tailor->tailorProfile;

        if (!$profile) {
            return back()->with('error', 'Penjahit belum memiliki profil.');
        }

        $profile->update(['is_verified' => !$profile->is_verified]);

        $status = $profile->is_verified ? 'ditampilkan di publik' : 'disembunyikan dari publik';

        return back()->with('success', "Profil penjahit {$tailor->name} berhasil {$status}.");
    }

    /**
     * Hapus akun penjahit.
     */
    public function destroy(User $tailor)
    {
        abort_if($tailor->role !== UserRole::Tailor, 404);

        $name = $tailor->name;
        $tailor->delete();

        return redirect()->route('admin.tailors.index')
            ->with('success', "Akun penjahit {$name} berhasil dihapus.");
    }
}
