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
        Schema::create('daftar_fotografer', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('nama');
            $table->string('alamat');
            $table->string('nowa');
            $table->string('foto_ktp');
            $table->string('pesan');
            $table->enum('status', ['Ditinjau', 'Diterima', 'Ditolak'])->default('Ditinjau');
            $table->boolean('is_validate')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_fotografer');
    }
};
