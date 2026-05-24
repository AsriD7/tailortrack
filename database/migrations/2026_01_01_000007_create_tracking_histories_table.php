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
        Schema::create('tracking_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
            $table->text('description')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_histories');
    }
};
