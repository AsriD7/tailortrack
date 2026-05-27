<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerMeasurement extends Model
{
    protected $fillable = [
        'customer_id',
        'label',
        'gender',
        'height_cm',
        'weight_kg',
        'chest_cm',
        'waist_cm',
        'hip_cm',
        'shoulder_cm',
        'sleeve_length_cm',
        'shirt_length_cm',
        'pants_length_cm',
        'thigh_cm',
        'notes',
    ];

    protected $casts = [
        'height_cm' => 'decimal:1',
        'weight_kg' => 'decimal:1',
        'chest_cm' => 'decimal:1',
        'waist_cm' => 'decimal:1',
        'hip_cm' => 'decimal:1',
        'shoulder_cm' => 'decimal:1',
        'sleeve_length_cm' => 'decimal:1',
        'shirt_length_cm' => 'decimal:1',
        'pants_length_cm' => 'decimal:1',
        'thigh_cm' => 'decimal:1',
    ];

    public const FIELD_LABELS = [
        'height_cm' => 'Tinggi Badan',
        'weight_kg' => 'Berat Badan',
        'chest_cm' => 'Lingkar Dada',
        'waist_cm' => 'Lingkar Pinggang',
        'hip_cm' => 'Lingkar Pinggul',
        'shoulder_cm' => 'Lebar Bahu',
        'sleeve_length_cm' => 'Panjang Lengan',
        'shirt_length_cm' => 'Panjang Baju',
        'pants_length_cm' => 'Panjang Celana/Rok',
        'thigh_cm' => 'Lingkar Paha',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function detailSnapshot(): array
    {
        $details = [];

        foreach (self::FIELD_LABELS as $field => $label) {
            if ($this->{$field} !== null) {
                $unit = $field === 'weight_kg' ? 'kg' : 'cm';
                $details[$label] = rtrim(rtrim((string) $this->{$field}, '0'), '.') . ' ' . $unit;
            }
        }

        return [
            'type' => 'custom_profile',
            'measurement_id' => $this->id,
            'label' => $this->label,
            'gender' => $this->gender,
            'details' => $details,
            'notes' => $this->notes,
        ];
    }
}
