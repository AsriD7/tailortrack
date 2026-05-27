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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tailor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('price_list_id')->nullable()->constrained('price_lists')->nullOnDelete();
            $table->string('order_code')->unique();
            $table->string('category');
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->enum('size', ['S', 'M', 'L', 'XL', 'XXL', 'Custom']);
            $table->json('measurement_snapshot')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('estimated_price', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->enum('status', [
                'menunggu_konfirmasi',
                'menunggu_pembayaran',
                'dibayar',
                'diproses',
                'finishing',
                'siap_diambil',
                'selesai',
                'dibatalkan',
            ])->default('menunggu_konfirmasi');
            $table->date('deadline')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('cancel_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
