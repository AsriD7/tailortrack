<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE payments MODIFY payment_type ENUM('full','dp','pelunasan') NOT NULL DEFAULT 'full'");
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("UPDATE payments SET payment_type = 'full' WHERE payment_type = 'pelunasan'");
        DB::statement("ALTER TABLE payments MODIFY payment_type ENUM('full','dp') NOT NULL DEFAULT 'full'");
    }
};
