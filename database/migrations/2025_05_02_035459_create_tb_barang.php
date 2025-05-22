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
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->ulid('id_barang')->primary();
            $table->string('kode_barang', 50); // Misalnya: R-001, KBL-009
            $table->string('nama_barang', 50); // Nama barang (Router, Kabel UTP)
            $table->string('jenis', 50); // kabel, router, wireless_radio
            $table->string('merek', 50); // Contoh: Mikrotik, TP-Link
            $table->string('tipe_model', 50)->nullable(); // Contoh: CCR1009
            $table->string('serial_number', 50)->nullable(); // Dari pabrik di bagian barang
            $table->string('satuan',  20); // pcs, roll, unit, meter
            $table->text('keterangan')->nullable(); // 	Info tambahan
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang');
    }
};
