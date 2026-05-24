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
        Schema::create('tailor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('shop_name');
            $table->string('specialization')->nullable();
            $table->text('description')->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('profile_photo')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('tailor_profiles');
    }
};
