<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast kolom ke tipe data yang sesuai.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role'     => UserRole::class,
        ];
    }

    // ==========================================
    // Relasi
    // ==========================================

    /**
     * Penjahit memiliki satu profil toko.
     */
    public function tailorProfile()
    {
        return $this->hasOne(TailorProfile::class, 'user_id');
    }

    /**
     * Order yang dibuat oleh customer ini.
     */
    public function customerOrders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * Order yang diterima oleh penjahit ini.
     */
    public function tailorOrders()
    {
        return $this->hasMany(Order::class, 'tailor_id');
    }

    /**
     * Portfolio milik penjahit ini.
     */
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'tailor_id');
    }

    /**
     * Riwayat tracking yang diupdate oleh user ini.
     */
    public function trackingHistories()
    {
        return $this->hasMany(TrackingHistory::class, 'updated_by');
    }

    // ==========================================
    // Method Helper Role
    // ==========================================

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    /**
     * Cek apakah user adalah penjahit.
     */
    public function isTailor(): bool
    {
        return $this->role === UserRole::Tailor;
    }

    /**
     * Cek apakah user adalah customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }
}
