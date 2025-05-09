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
            $table->foreignUuid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete(); // ambil barang dari tb barang
            $table->foreignUuid('id_pelanggan')->constrained('tb_pelanggan', 'id_pelanggan')->cascadeOnDelete(); //  ambil pelanggan dari tb_pelanggan
            $table->date('tanggal'); // tanggal barang keluar
            $table->integer('jumlah'); // jumlah barang keluar
            $table->enum('tujuan', ['pemasangan', 'pergantian']); // pemasangan atau perggantian Dll.
            $table->string('satuan',  20); // pcs, roll, unit, meter
            $table->string('petugas', 50);
            $table->string('lokasi', 150); // lokasi barang
            $table->text('keterangan'); // catatan tambahan
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
