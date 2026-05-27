<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE orders MODIFY status ENUM('menunggu_konfirmasi','menunggu_pembayaran','dibayar','diproses','finishing','siap_diambil','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu_konfirmasi'");
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE orders MODIFY status ENUM('menunggu_konfirmasi','menunggu_pembayaran','dibayar','diproses','selesai','dibatalkan') NOT NULL DEFAULT 'menunggu_konfirmasi'");
    }
};
