<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const TYPE_FULL = 'full';
    public const TYPE_DP = 'dp';
    public const TYPE_FINAL = 'pelunasan';

    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'order_id',
        'payment_type',
        'amount',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'payment_proof',
        'payment_date',
        'status',
    ];

    /**
     * Cast kolom ke tipe data yang sesuai.
     */
    protected $casts = [
        'status'       => PaymentStatus::class,
        'amount'       => 'decimal:2',
        'payment_date' => 'date',
    ];

    // ==========================================
    // Relasi
    // ==========================================

    /**
     * Pembayaran ini untuk satu order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // ==========================================
    // Accessor
    // ==========================================

    /**
     * Dapatkan URL bukti pembayaran.
     */
    public function getPaymentProofUrlAttribute(): string
    {
        return asset('storage/' . $this->payment_proof);
    }

    public function getPaymentTypeLabelAttribute(): string
    {
        return match ($this->payment_type) {
            self::TYPE_DP => 'DP / Panjar',
            self::TYPE_FINAL => 'Pelunasan',
            default => 'Bayar Full',
        };
    }

    public function formattedAmount(): string
    {
        if ($this->amount === null) {
            return '-';
        }

        return 'Rp ' . number_format((float) $this->amount, 0, ',', '.');
    }
}
