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
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('client_type')->nullable()->after('category');
            $table->string('price_range')->nullable()->after('client_type');
            $table->date('completed_at')->nullable()->after('price_range');
            $table->boolean('is_featured')->default(false)->after('completed_at');
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['client_type', 'price_range', 'completed_at', 'is_featured']);
        });
    }
};
