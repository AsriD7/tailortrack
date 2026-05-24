<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending  = 'pending';
    case Verified = 'verified';
    case Rejected = 'rejected';

    /**
     * Label tampilan untuk setiap status pembayaran.
     */
    public function label(): string
    {
        return match($this) {
            PaymentStatus::Pending  => 'Menunggu Verifikasi',
            PaymentStatus::Verified => 'Terverifikasi',
            PaymentStatus::Rejected => 'Ditolak',
        };
    }

    /**
     * Warna badge Tailwind CSS untuk setiap status pembayaran.
     */
    public function badgeColor(): string
    {
        return match($this) {
            PaymentStatus::Pending  => 'bg-yellow-100 text-yellow-700',
            PaymentStatus::Verified => 'bg-emerald-100 text-emerald-700',
            PaymentStatus::Rejected => 'bg-red-100 text-red-700',
        };
    }
}
