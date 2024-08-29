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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('totalharga');
            $table->text('catatan')->nullable();
            $table->enum('status', ['Diproses', 'Menunggu Pembayaran', 'Selesai', 'Dibatalkan'])->nullable();
            $table->boolean('is_selesai')->default(false);
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
