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
            $table->ulid('id_barang_keluar')->primary();
            $table->foreignUlid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete(); // ambil barang dari tb barang
            $table->foreignUlid('id_pelanggan')->constrained('tb_pelanggan', 'id_pelanggan')->cascadeOnDelete(); //  ambil pelanggan dari tb_pelanggan
            $table->foreignUlid('id_stok')->constrained('tb_stok', 'id_stok')->cascadeOnDelete(); //  ambil stok dari tb_stok
            $table->string('kode_barang_keluar', 25); // kode barang keluar
            $table->date('tanggal'); // tanggal barang keluar
            $table->integer('jumlah'); // jumlah barang keluar
            $table->enum('tujuan', ['pemasangan', 'pergantian']); // pemasangan atau perggantian Dll.
            $table->string('satuan',  20); // pcs, roll, unit, meter
            $table->string('petugas', 50);
            $table->string('lokasi', 50); // lokasi barang
            $table->string('keterangan', 250)->nullable(); // catatan tambahan
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
