<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TailorUnavailableDate extends Model
{
    protected $fillable = [
        'tailor_id',
        'date',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function tailor()
    {
        return $this->belongsTo(User::class, 'tailor_id');
    }
}
