<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'customer_id',
        'tailor_id',
        'price_list_id',
        'order_code',
        'category',
        'item_name',
        'description',
        'size',
        'quantity',
        'estimated_price',
        'total_price',
        'status',
        'deadline',
        'note',
        'cancelled_by',
        'cancel_reason',
        'cancelled_at',
    ];

    /**
     * Cast kolom ke tipe data yang sesuai.
     */
    protected $casts = [
        'status'          => OrderStatus::class,
        'estimated_price' => 'decimal:2',
        'total_price'     => 'decimal:2',
        'deadline'        => 'date',
        'cancelled_at'    => 'datetime',
        'quantity'        => 'integer',
    ];

    // ==========================================
    // Relasi
    // ==========================================

    /**
     * Order ini dibuat oleh customer.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Order ini diterima oleh penjahit.
     */
    public function tailor()
    {
        return $this->belongsTo(User::class, 'tailor_id');
    }

    /**
     * Order ini menggunakan jenis layanan dari daftar harga.
     */
    public function priceList()
    {
        return $this->belongsTo(PriceList::class, 'price_list_id');
    }

    /**
     * Order ini memiliki banyak gambar referensi.
     */
    public function orderImages()
    {
        return $this->hasMany(OrderImage::class, 'order_id');
    }

    /**
     * Order ini memiliki satu data pembayaran.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    /**
     * Order ini memiliki banyak riwayat tracking.
     */
    public function trackingHistories()
    {
        return $this->hasMany(TrackingHistory::class, 'order_id')->orderBy('created_at', 'asc');
    }

    /**
     * Order ini dibatalkan oleh user tertentu.
     */
    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * Order ini memiliki satu ulasan dari customer.
     */
    public function review()
    {
        return $this->hasOne(Review::class, 'order_id');
    }


    // ==========================================
    // Method Helper
    // ==========================================

    /**
     * Generate kode order unik dengan format TT-YYYYMMDD-XXXX.
     */
    public static function generateOrderCode(): string
    {
        $date   = Carbon::now()->format('Ymd');
        $prefix = "TT-{$date}-";

        // Cari nomor urut terakhir pada hari ini
        $last = static::where('order_code', 'like', $prefix . '%')
            ->orderBy('order_code', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->order_code, -4);
            $newNumber  = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Cek apakah order boleh dibatalkan oleh user tertentu.
     */
    public function canBeCancelledBy(User $user): bool
    {
        // Admin bisa batalkan kapanpun selama belum selesai
        if ($user->isAdmin()) {
            return !in_array($this->status, [OrderStatus::Selesai, OrderStatus::Dibatalkan]);
        }

        // Penjahit hanya boleh batalkan jika status menunggu konfirmasi
        if ($user->isTailor() && $user->id === $this->tailor_id) {
            return $this->status === OrderStatus::MenungguKonfirmasi;
        }

        // Customer boleh batalkan jika status masih menunggu konfirmasi atau menunggu pembayaran
        if ($user->isCustomer() && $user->id === $this->customer_id) {
            return in_array($this->status, OrderStatus::cancellableByCustomer());
        }

        return false;
    }

    /**
     * Hitung estimasi harga berdasarkan harga dasar, ukuran, dan jumlah.
     */
    public function calculateEstimatedPrice(): float
    {
        $basePrice = $this->priceList ? (float) $this->priceList->base_price : 0;

        // Tambahan harga berdasarkan ukuran
        $sizeExtra = match($this->size) {
            'S', 'M' => 0,
            'L'      => 5000,
            'XL'     => 10000,
            'XXL'    => 15000,
            'Custom' => 20000,
            default  => 0,
        };

        return ($basePrice + $sizeExtra) * $this->quantity;
    }

    /**
     * Format estimated_price ke Rupiah.
     */
    public function formattedEstimatedPrice(): string
    {
        return 'Rp ' . number_format((float)$this->estimated_price, 0, ',', '.');
    }

    /**
     * Format total_price ke Rupiah.
     */
    public function formattedTotalPrice(): string
    {
        if (!$this->total_price) return '-';
        return 'Rp ' . number_format((float)$this->total_price, 0, ',', '.');
    }
}
