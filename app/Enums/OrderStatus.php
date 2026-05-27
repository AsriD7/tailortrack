<?php

namespace App\Enums;

enum OrderStatus: string
{
    case MenungguKonfirmasi  = 'menunggu_konfirmasi';
    case MenungguPembayaran  = 'menunggu_pembayaran';
    case Dibayar             = 'dibayar';
    case Diproses            = 'diproses';
    case Finishing           = 'finishing';
    case SiapDiambil         = 'siap_diambil';
    case Selesai             = 'selesai';
    case Dibatalkan          = 'dibatalkan';

    /**
     * Label tampilan untuk setiap status.
     */
    public function label(): string
    {
        return match($this) {
            OrderStatus::MenungguKonfirmasi => 'Menunggu Konfirmasi',
            OrderStatus::MenungguPembayaran => 'Menunggu Pembayaran',
            OrderStatus::Dibayar            => 'Dibayar',
            OrderStatus::Diproses           => 'Diproses',
            OrderStatus::Finishing          => 'Finishing',
            OrderStatus::SiapDiambil        => 'Siap Diambil',
            OrderStatus::Selesai            => 'Selesai',
            OrderStatus::Dibatalkan         => 'Dibatalkan',
        };
    }

    /**
     * Warna badge Tailwind CSS untuk setiap status.
     */
    public function badgeColor(): string
    {
        return match($this) {
            OrderStatus::MenungguKonfirmasi => 'bg-yellow-100 text-yellow-700',
            OrderStatus::MenungguPembayaran => 'bg-orange-100 text-orange-700',
            OrderStatus::Dibayar            => 'bg-blue-100 text-blue-700',
            OrderStatus::Diproses           => 'bg-indigo-100 text-indigo-700',
            OrderStatus::Finishing          => 'bg-purple-100 text-purple-700',
            OrderStatus::SiapDiambil        => 'bg-teal-100 text-teal-700',
            OrderStatus::Selesai            => 'bg-emerald-100 text-emerald-700',
            OrderStatus::Dibatalkan         => 'bg-red-100 text-red-700',
        };
    }

    /**
     * Status yang boleh dibatalkan oleh customer.
     */
    public static function cancellableByCustomer(): array
    {
        return [
            self::MenungguKonfirmasi,
            self::MenungguPembayaran,
        ];
    }

    /**
     * Status yang boleh dibatalkan oleh penjahit.
     */
    public static function cancellableByTailor(): array
    {
        return [
            self::MenungguKonfirmasi,
        ];
    }

    /**
     * Status progres yang dikelola langsung oleh penjahit setelah payment diverifikasi admin.
     */
    public static function tailorProgressStatuses(): array
    {
        return [
            self::Diproses,
            self::Finishing,
            self::SiapDiambil,
            self::Selesai,
        ];
    }

    /**
     * Status lanjutan yang boleh dipilih penjahit dari status saat ini.
     */
    public function availableTailorProgressTargets(): array
    {
        $progress = self::tailorProgressStatuses();
        $currentIndex = array_search($this, $progress, true);

        if ($currentIndex === false || $this === self::Selesai) {
            return [];
        }

        return array_slice($progress, $currentIndex + 1);
    }

    public function defaultTrackingDescription(): string
    {
        return match($this) {
            self::Diproses => 'Pesanan mulai diproses oleh penjahit.',
            self::Finishing => 'Pesanan masuk tahap finishing.',
            self::SiapDiambil => 'Pesanan sudah siap diambil oleh customer.',
            self::Selesai => 'Pesanan telah selesai dikerjakan oleh penjahit.',
            default => "Status pesanan diperbarui menjadi {$this->label()}.",
        };
    }
}
