<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'order_id',
        'customer_id',
        'tailor_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // ==========================================
    // Relasi
    // ==========================================

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function tailor()
    {
        return $this->belongsTo(User::class, 'tailor_id');
    }

    // ==========================================
    // Helper
    // ==========================================

    /**
     * Render bintang dalam bentuk array boolean [true, true, false, ...]
     */
    public function getStarsAttribute(): array
    {
        return array_map(fn($i) => $i <= $this->rating, range(1, 5));
    }

    /**
     * Label teks rating
     */
    public function getRatingLabelAttribute(): string
    {
        return match ($this->rating) {
            5 => 'Sangat Puas',
            4 => 'Puas',
            3 => 'Cukup',
            2 => 'Kurang',
            1 => 'Sangat Kurang',
            default => '-',
        };
    }
}
