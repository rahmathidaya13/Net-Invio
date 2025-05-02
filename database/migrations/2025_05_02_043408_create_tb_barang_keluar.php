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
        Schema::create('tb_barang_keluar', function (Blueprint $table) {
            $table->uuid('id_barang_keluar')->primary();
            $table->foreignUuid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete();
            $table->foreignUuid('id_pelanggan')->constrained('tb_pelanggan', 'id_pelanggan')->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->string('tujuan', 50); // pemasangan atau perggantian
            $table->text('keterangan');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang_keluar');
    }
};
