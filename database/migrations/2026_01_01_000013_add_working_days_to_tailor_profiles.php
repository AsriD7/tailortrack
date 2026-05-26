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
            $table->json('working_days')->nullable()->after('estimated_processing_days');
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::table('tailor_profiles', function (Blueprint $table) {
            $table->dropColumn('working_days');
        });
    }
};
