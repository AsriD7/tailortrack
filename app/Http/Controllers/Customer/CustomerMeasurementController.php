<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMeasurementController extends Controller
{
    public function index()
    {
        $measurements = Auth::user()
            ->measurements()
            ->latest()
            ->paginate(8);

        return view('customer.measurements.index', compact('measurements'));
    }

    public function create()
    {
        return view('customer.measurements.create', [
            'measurement' => new CustomerMeasurement(),
        ]);
    }

    public function store(Request $request)
    {
        Auth::user()->measurements()->create($this->validatedData($request));

        return redirect()
            ->route('customer.measurements.index')
            ->with('success', 'Profil ukuran berhasil disimpan.');
    }

    public function edit(CustomerMeasurement $measurement)
    {
        $this->authorizeMeasurement($measurement);

        return view('customer.measurements.edit', compact('measurement'));
    }

    public function update(Request $request, CustomerMeasurement $measurement)
    {
        $this->authorizeMeasurement($measurement);

        $measurement->update($this->validatedData($request));

        return redirect()
            ->route('customer.measurements.index')
            ->with('success', 'Profil ukuran berhasil diperbarui.');
    }

    public function destroy(CustomerMeasurement $measurement)
    {
        $this->authorizeMeasurement($measurement);

        $measurement->delete();

        return redirect()
            ->route('customer.measurements.index')
            ->with('success', 'Profil ukuran berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'label' => 'required|string|max:100',
            'gender' => 'nullable|string|max:30',
            'height_cm' => 'nullable|numeric|min:1|max:300',
            'weight_kg' => 'nullable|numeric|min:1|max:300',
            'chest_cm' => 'nullable|numeric|min:1|max:300',
            'waist_cm' => 'nullable|numeric|min:1|max:300',
            'hip_cm' => 'nullable|numeric|min:1|max:300',
            'shoulder_cm' => 'nullable|numeric|min:1|max:300',
            'sleeve_length_cm' => 'nullable|numeric|min:1|max:300',
            'shirt_length_cm' => 'nullable|numeric|min:1|max:300',
            'pants_length_cm' => 'nullable|numeric|min:1|max:300',
            'thigh_cm' => 'nullable|numeric|min:1|max:300',
            'notes' => 'nullable|string|max:500',
        ]);
    }

    private function authorizeMeasurement(CustomerMeasurement $measurement): void
    {
        abort_if($measurement->customer_id !== Auth::id(), 403, 'Akses ditolak.');
    }
}
