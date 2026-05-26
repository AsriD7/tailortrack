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
        'client_type',
        'price_range',
        'completed_at',
        'is_featured',
        'image',
        'description',
    ];

    /**
     * Cast kolom ke tipe data yang sesuai.
     */
    protected $casts = [
        'completed_at' => 'date',
        'is_featured' => 'boolean',
    ];

    /**
     * Kategori umum untuk portfolio penjahit.
     */
    public const CATEGORY_OPTIONS = [
        'Atasan',
        'Bawahan',
        'Dress & Gaun',
        'Kebaya',
        'Jas & Setelan',
        'Seragam',
        'Almamater',
        'Batik',
        'Pakaian Anak',
        'Permak',
        'Lainnya',
    ];

    /**
     * Tipe pelanggan/proyek untuk memberi konteks pada karya.
     */
    public const CLIENT_TYPE_OPTIONS = [
        'Pribadi',
        'Wisuda',
        'Pernikahan',
        'Kantor',
        'Sekolah / Kampus',
        'Komunitas',
        'Lainnya',
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
