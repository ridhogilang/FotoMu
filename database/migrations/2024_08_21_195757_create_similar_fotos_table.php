<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('similar_foto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('foto_id');
            $table->boolean('is_hapus')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('similar_foto');
    }
};
