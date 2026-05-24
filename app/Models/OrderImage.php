<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'order_id',
        'image',
        'created_at',
    ];

    /**
     * Cast kolom ke tipe data yang sesuai.
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ==========================================
    // Relasi
    // ==========================================

    /**
     * Gambar ini milik satu order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // ==========================================
    // Accessor
    // ==========================================

    /**
     * Dapatkan URL gambar referensi order.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
