<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
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
        'measurement_snapshot',
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
        'measurement_snapshot' => 'array',
        'cancelled_at'    => 'datetime',
        'quantity'        => 'integer',
    ];

    public const SIZE_SURCHARGES = [
        'S' => 0,
        'M' => 0,
        'L' => 5000,
        'XL' => 10000,
        'XXL' => 15000,
        'Custom' => 20000,
    ];

    public const STANDARD_SIZE_DETAILS = [
        'S' => [
            'Lingkar Dada' => '86-90 cm',
            'Lingkar Pinggang' => '70-74 cm',
            'Lingkar Pinggul' => '88-92 cm',
            'Lebar Bahu' => '38-40 cm',
            'Panjang Baju' => '64-66 cm',
        ],
        'M' => [
            'Lingkar Dada' => '91-96 cm',
            'Lingkar Pinggang' => '75-80 cm',
            'Lingkar Pinggul' => '93-98 cm',
            'Lebar Bahu' => '40-42 cm',
            'Panjang Baju' => '66-68 cm',
        ],
        'L' => [
            'Lingkar Dada' => '97-102 cm',
            'Lingkar Pinggang' => '81-86 cm',
            'Lingkar Pinggul' => '99-104 cm',
            'Lebar Bahu' => '42-44 cm',
            'Panjang Baju' => '68-70 cm',
        ],
        'XL' => [
            'Lingkar Dada' => '103-110 cm',
            'Lingkar Pinggang' => '87-94 cm',
            'Lingkar Pinggul' => '105-112 cm',
            'Lebar Bahu' => '44-46 cm',
            'Panjang Baju' => '70-72 cm',
        ],
        'XXL' => [
            'Lingkar Dada' => '111-118 cm',
            'Lingkar Pinggang' => '95-102 cm',
            'Lingkar Pinggul' => '113-120 cm',
            'Lebar Bahu' => '46-48 cm',
            'Panjang Baju' => '72-74 cm',
        ],
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
     * Order ini memiliki riwayat pembayaran.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id')->latest();
    }

    /**
     * Payment terakhir, agar tampilan lama tetap mengambil data terbaru.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id')->latestOfMany();
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

    public static function standardSizeSnapshot(string $size): ?array
    {
        if (!isset(self::STANDARD_SIZE_DETAILS[$size])) {
            return null;
        }

        return [
            'type' => 'standard',
            'label' => 'Ukuran ' . $size,
            'size' => $size,
            'details' => self::STANDARD_SIZE_DETAILS[$size],
            'notes' => 'Ukuran standar sebagai acuan awal. Penjahit tetap dapat menyesuaikan berdasarkan model pakaian.',
        ];
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
        $sizeExtra = self::SIZE_SURCHARGES[$this->size] ?? 0;

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

    public function verifiedPaymentsTotal(): float
    {
        if ($this->relationLoaded('payments')) {
            return (float) $this->payments
                ->filter(fn(Payment $payment) => $payment->status === PaymentStatus::Verified)
                ->sum(fn(Payment $payment) => (float) $payment->amount);
        }

        return (float) $this->payments()
            ->where('status', PaymentStatus::Verified->value)
            ->sum('amount');
    }

    public function paymentRemainingAmount(): float
    {
        return max(0, (float) $this->total_price - $this->verifiedPaymentsTotal());
    }

    public function formattedVerifiedPaymentsTotal(): string
    {
        return 'Rp ' . number_format($this->verifiedPaymentsTotal(), 0, ',', '.');
    }

    public function formattedPaymentRemainingAmount(): string
    {
        return 'Rp ' . number_format($this->paymentRemainingAmount(), 0, ',', '.');
    }

    public function hasVerifiedDpPayment(): bool
    {
        if ($this->relationLoaded('payments')) {
            return $this->payments->contains(fn(Payment $payment) =>
                $payment->payment_type === Payment::TYPE_DP
                && $payment->status === PaymentStatus::Verified
            );
        }

        return $this->payments()
            ->where('payment_type', Payment::TYPE_DP)
            ->where('status', PaymentStatus::Verified->value)
            ->exists();
    }

    public function hasPendingFinalPayment(): bool
    {
        if ($this->relationLoaded('payments')) {
            return $this->payments->contains(fn(Payment $payment) =>
                $payment->payment_type === Payment::TYPE_FINAL
                && $payment->status === PaymentStatus::Pending
            );
        }

        return $this->payments()
            ->where('payment_type', Payment::TYPE_FINAL)
            ->where('status', PaymentStatus::Pending->value)
            ->exists();
    }

    public function isFullyPaid(): bool
    {
        return (float) $this->total_price > 0 && $this->paymentRemainingAmount() <= 0;
    }
}
