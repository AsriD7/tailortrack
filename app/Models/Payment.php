<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'order_id',
        'payment_proof',
        'payment_date',
        'status',
    ];

    /**
     * Cast kolom ke tipe data yang sesuai.
     */
    protected $casts = [
        'status'       => PaymentStatus::class,
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
}
