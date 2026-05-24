<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'tailor_id',
        'title',
        'category',
        'image',
        'description',
    ];

    // ==========================================
    // Relasi
    // ==========================================

    /**
     * Portfolio ini milik satu penjahit.
     */
    public function tailor()
    {
        return $this->belongsTo(User::class, 'tailor_id');
    }

    // ==========================================
    // Accessor
    // ==========================================

    /**
     * Dapatkan URL gambar portfolio.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
