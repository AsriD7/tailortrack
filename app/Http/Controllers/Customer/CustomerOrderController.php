<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderImage;
use App\Models\PriceList;
use App\Models\TrackingHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerOrderController extends Controller
{
    /**
     * Tampilkan semua order milik customer yang sedang login.
     */
    public function index()
    {
        $orders = Auth::user()->customerOrders()
            ->with(['tailor.tailorProfile', 'priceList'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Tampilkan form pembuatan order untuk penjahit tertentu.
     */
    public function create(User $tailor)
    {
        // Pastikan target adalah penjahit yang valid
        abort_if(
            $tailor->role !== UserRole::Tailor || !$tailor->tailorProfile?->is_verified,
            404,
            'Penjahit tidak ditemukan.'
        );

        $tailor->load(['tailorProfile', 'priceLists' => fn($q) => $q->orderBy('category')->orderBy('name')]);
        $priceLists = $tailor->priceLists;

        return view('customer.orders.create', compact('tailor', 'priceLists'));
    }

    /**
     * Simpan order baru dari customer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tailor_id'      => 'required|exists:users,id',
            'price_list_id'  => 'required|exists:price_lists,id',
            'description'    => 'nullable|string|max:1000',
            'size'           => 'required|in:S,M,L,XL,XXL,Custom',
            'quantity'       => 'required|integer|min:1|max:100',
            'deadline'       => 'nullable|date|after_or_equal:today',
            'note'           => 'nullable|string|max:500',
            'images'         => 'nullable|array|max:5',
            'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'tailor_id.required'     => 'Penjahit wajib dipilih.',
            'price_list_id.required' => 'Jenis layanan wajib dipilih.',
            'size.required'          => 'Ukuran wajib dipilih.',
            'quantity.required'      => 'Jumlah wajib diisi.',
            'quantity.min'           => 'Jumlah minimal 1.',
            'images.max'             => 'Maksimal 5 gambar referensi.',
            'images.*.image'         => 'File harus berupa gambar.',
            'images.*.max'           => 'Ukuran gambar maksimal 2MB.',
        ]);

        $tailor    = User::findOrFail($request->tailor_id);
        $priceList = PriceList::findOrFail($request->price_list_id);

        if (!$tailor->priceLists()->where('price_lists.id', $priceList->id)->exists()) {
            return back()
                ->withErrors(['price_list_id' => 'Layanan ini tidak tersedia untuk penjahit yang dipilih.'])
                ->withInput();
        }

        // Hitung estimasi harga
        $sizeExtra = match($request->size) {
            'S', 'M' => 0,
            'L'      => 5000,
            'XL'     => 10000,
            'XXL'    => 15000,
            'Custom' => 20000,
            default  => 0,
        };
        $estimatedPrice = ((float)$priceList->base_price + $sizeExtra) * $request->quantity;

        // Buat order
        $order = Order::create([
            'customer_id'     => Auth::id(),
            'tailor_id'       => $tailor->id,
            'price_list_id'   => $priceList->id,
            'order_code'      => Order::generateOrderCode(),
            'category'        => $priceList->category,
            'item_name'       => $priceList->name,
            'description'     => $request->description,
            'size'            => $request->size,
            'quantity'        => $request->quantity,
            'estimated_price' => $estimatedPrice,
            'total_price'     => null,
            'status'          => OrderStatus::MenungguKonfirmasi,
            'deadline'        => $request->deadline,
            'note'            => $request->note,
        ]);

        // Upload gambar referensi (maks 5)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store("orders/{$order->id}", 'public');
                OrderImage::create([
                    'order_id'   => $order->id,
                    'image'      => $path,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        // Buat tracking history awal
        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => OrderStatus::MenungguKonfirmasi->value,
            'description' => 'Pesanan dibuat oleh customer dan menunggu konfirmasi penjahit.',
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('customer.orders.show', $order)
            ->with('success', "Pesanan #{$order->order_code} berhasil dibuat! Menunggu konfirmasi penjahit.");
    }

    /**
     * Tampilkan detail satu order milik customer.
     */
    public function show(Order $order)
    {
        // Pastikan order ini milik customer yang login
        abort_if($order->customer_id !== Auth::id(), 403, 'Akses ditolak.');

        $order->load(['tailor.tailorProfile', 'priceList', 'orderImages', 'payment', 'trackingHistories.updatedByUser']);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Customer membatalkan order.
     */
    public function cancel(Request $request, Order $order)
    {
        abort_if($order->customer_id !== Auth::id(), 403, 'Akses ditolak.');

        $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ], [
            'cancel_reason.required' => 'Alasan pembatalan wajib diisi.',
        ]);

        if (!$order->canBeCancelledBy(Auth::user())) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan pada status saat ini.');
        }

        $order->update([
            'status'       => OrderStatus::Dibatalkan,
            'cancelled_by' => Auth::id(),
            'cancel_reason' => $request->cancel_reason,
            'cancelled_at'  => Carbon::now(),
        ]);

        TrackingHistory::create([
            'order_id'    => $order->id,
            'updated_by'  => Auth::id(),
            'status'      => OrderStatus::Dibatalkan->value,
            'description' => "Pesanan dibatalkan oleh customer. Alasan: {$request->cancel_reason}",
            'created_at'  => Carbon::now(),
        ]);

        return redirect()->route('customer.orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
