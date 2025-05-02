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
        Schema::create('tb_retur_barang', function (Blueprint $table) {
            $table->uuid('id_retur')->primary();
            $table->foreignUuid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete();
            $table->foreignUuid('id_pelanggan')->nullable()->constrained('tb_pelanggan', 'id_pelanggan')->cascadeOnDelete();
            $table->foreignUuid('id_supplier')->nullable()->constrained('tb_supplier', 'id_supplier')->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->enum('tipe_retur', ['masuk', 'keluar']);
            $table->enum('status_pergantian', ['diganti', 'tidak_diganti', 'diperbaiki']);
            $table->text('alasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_retur_barang');
    }
};
