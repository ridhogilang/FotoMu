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
        Schema::create('earning', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fotografer_id');
            $table->bigInteger('detail_pesanan_id')->nullable();
            $table->bigInteger('withdrawal_id')->nullable();
            $table->decimal('uang_masuk')->nullable();
            $table->decimal('uang_keluar')->nullable();
            $table->decimal('jumlah');
            $table->enum('status', ['Pendapatan', 'Penarikan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earning');
    }
};
