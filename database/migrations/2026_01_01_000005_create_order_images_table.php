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
        Schema::create('order_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('image');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_images');
    }
};
