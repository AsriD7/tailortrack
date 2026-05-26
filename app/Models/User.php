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
     * Layanan jahit yang diterima oleh penjahit ini.
     */
    public function priceLists()
    {
        return $this->belongsToMany(PriceList::class, 'tailor_price_lists', 'tailor_id', 'price_list_id')
            ->withPivot('custom_price')
            ->withTimestamps();
    }

    /**
     * Riwayat tracking yang diupdate oleh user ini.
     */
    public function trackingHistories()
    {
        return $this->hasMany(TrackingHistory::class, 'updated_by');
    }

    /**
     * Ulasan yang diberikan oleh customer ini.
     */
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    /**
     * Ulasan yang diterima oleh penjahit ini.
     */
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'tailor_id');
    }

    /**
     * Rata-rata rating penjahit ini.
     */
    public function getAvgRatingAttribute(): ?float
    {
        $avg = $this->reviewsReceived()->avg('rating');
        return $avg ? round($avg, 1) : null;
    }

    /**
     * Jumlah ulasan penjahit ini.
     */
    public function getReviewCountAttribute(): int
    {
        return $this->reviewsReceived()->count();
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
