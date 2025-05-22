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
        Schema::create('log_stok', function (Blueprint $table) {
            $table->ulid('id_log_stok')->primary();
            $table->uuid('id_barang');
            $table->date('tanggal');
            $table->enum('tipe', ['barang_masuk', 'barang_keluar', 'barang_tersedia']);
            $table->integer('jumlah');
            $table->string('lokasi', 50);
            $table->string('keterangan', 250)->nullable();
            $table->string('dibuat_oleh', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_stok');
    }
};
