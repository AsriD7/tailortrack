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
        Schema::create('tailor_price_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tailor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('price_list_id')->constrained('price_lists')->cascadeOnDelete();
            $table->decimal('custom_price', 12, 2)->nullable();
            $table->timestamps();

            $table->unique(['tailor_id', 'price_list_id']);
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('tailor_price_lists');
    }
};
