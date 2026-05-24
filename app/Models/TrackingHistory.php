<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'order_id',
        'updated_by',
        'status',
        'description',
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
     * Tracking ini untuk satu order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Tracking ini diupdate oleh satu user.
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
