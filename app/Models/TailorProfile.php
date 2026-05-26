<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TailorProfile extends Model
{
    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'user_id',
        'shop_name',
        'specialization',
        'description',
        'experience_years',
        'profile_photo',
        'is_verified',
        'is_available',
        'max_active_orders',
        'max_weekly_orders',
        'estimated_processing_days',
        'working_days',
    ];

    /**
     * Cast kolom ke tipe data yang sesuai.
     */
    protected $casts = [
        'is_verified'  => 'boolean',
        'is_available' => 'boolean',
        'max_active_orders' => 'integer',
        'max_weekly_orders' => 'integer',
        'estimated_processing_days' => 'integer',
        'working_days' => 'array',
    ];

    public const WORKING_DAY_LABELS = [
        0 => 'Minggu',
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
    ];

    // ==========================================
    // Relasi
    // ==========================================

    /**
     * Profil ini milik satu user (penjahit).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==========================================
    // Accessor
    // ==========================================

    /**
     * Accessor: ->photo maps ke kolom profile_photo
     * (views menggunakan ->photo, kolom DB adalah profile_photo)
     */
    public function getPhotoAttribute(): ?string
    {
        return $this->profile_photo;
    }

    /**
     * Dapatkan URL foto profil penjahit.
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        // Foto default jika belum upload
        return asset('images/default-avatar.png');
    }
}
