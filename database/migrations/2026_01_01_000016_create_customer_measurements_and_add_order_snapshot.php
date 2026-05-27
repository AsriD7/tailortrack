<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->string('label');
            $table->string('gender')->nullable();
            $table->decimal('height_cm', 5, 1)->nullable();
            $table->decimal('weight_kg', 5, 1)->nullable();
            $table->decimal('chest_cm', 5, 1)->nullable();
            $table->decimal('waist_cm', 5, 1)->nullable();
            $table->decimal('hip_cm', 5, 1)->nullable();
            $table->decimal('shoulder_cm', 5, 1)->nullable();
            $table->decimal('sleeve_length_cm', 5, 1)->nullable();
            $table->decimal('shirt_length_cm', 5, 1)->nullable();
            $table->decimal('pants_length_cm', 5, 1)->nullable();
            $table->decimal('thigh_cm', 5, 1)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {

        Schema::dropIfExists('customer_measurements');
    }
};
