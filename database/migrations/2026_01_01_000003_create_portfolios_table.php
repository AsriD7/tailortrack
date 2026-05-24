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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tailor_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('image');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
