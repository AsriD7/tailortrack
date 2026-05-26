<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::table('tailor_profiles', function (Blueprint $table) {
            $table->unsignedInteger('max_active_orders')->nullable()->after('is_available');
            $table->unsignedInteger('max_weekly_orders')->nullable()->after('max_active_orders');
            $table->unsignedInteger('estimated_processing_days')->nullable()->after('max_weekly_orders');
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::table('tailor_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'max_active_orders',
                'max_weekly_orders',
                'estimated_processing_days',
            ]);
        });
    }
};
