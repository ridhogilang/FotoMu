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
        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('event_id');
            $table->string('foto');
            $table->string('fotowatermark')->nullable();
            $table->string('harga');
            $table->string('deskripsi')->nullable();
            $table->string('file_size')->nullable();;
            $table->enum('resolusi', ['low', 'medium', 'high'])->nullable();;
            $table->timestamps();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto');
    }
};
