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
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->text('description')->nullable();
            $table->decimal('base_price', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_lists');
    }
};
