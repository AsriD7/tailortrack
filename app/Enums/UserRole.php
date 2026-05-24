<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin    = 'admin';
    case Tailor   = 'tailor';
    case Customer = 'customer';

    /**
     * Label tampilan untuk setiap role.
     */
    public function label(): string
    {
        return match($this) {
            UserRole::Admin    => 'Admin',
            UserRole::Tailor   => 'Penjahit',
            UserRole::Customer => 'Customer',
        };
    }

    /**
     * Warna badge Tailwind CSS untuk setiap role.
     */
    public function badgeColor(): string
    {
        return match($this) {
            UserRole::Admin    => 'bg-red-100 text-red-700',
            UserRole::Tailor   => 'bg-indigo-100 text-indigo-700',
            UserRole::Customer => 'bg-emerald-100 text-emerald-700',
        };
    }
}
