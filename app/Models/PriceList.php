<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'base_price',
    ];

    /**
     * Cast kolom ke tipe data yang sesuai.
     */
    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    // ==========================================
    // Relasi
    // ==========================================

    /**
     * Daftar harga ini memiliki banyak order.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'price_list_id');
    }

    // ==========================================
    // Helper
    // ==========================================

    /**
     * Format harga dasar ke Rupiah.
     */
    public function formattedBasePrice(): string
    {
        return 'Rp ' . number_format($this->base_price, 0, ',', '.');
    }
}
