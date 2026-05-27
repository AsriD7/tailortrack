<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_type', ['full', 'dp'])->default('full')->after('order_id');
            $table->decimal('amount', 12, 2)->nullable()->after('payment_type');
            $table->string('bank_name')->nullable()->after('amount');
            $table->string('bank_account_number')->nullable()->after('bank_name');
            $table->string('bank_account_name')->nullable()->after('bank_account_number');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'payment_type',
                'amount',
                'bank_name',
                'bank_account_number',
                'bank_account_name',
            ]);
        });
    }
};
