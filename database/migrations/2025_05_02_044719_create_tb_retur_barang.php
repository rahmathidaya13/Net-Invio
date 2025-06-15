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
            $table->ulid('id_retur')->primary();
            $table->foreignUlid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete(); // ambil barang dari tb_barang
            $table->foreignUlid('id_pelanggan')->nullable()->constrained('tb_pelanggan', 'id_pelanggan')->cascadeOnDelete(); // ambil pelanggan jika barang dari pelanggan
            $table->foreignUlid('id_supplier')->nullable()->constrained('tb_supplier', 'id_supplier')->cascadeOnDelete(); // ambil supplier jika barang dari supplier
            $table->string('kode_retur', 50); // tanggal retur
            $table->date('tanggal'); // tanggal retur
            $table->integer('jumlah'); // jumlah barang retur
            $table->enum('tipe_retur', ['masuk', 'keluar']); // jenis retur masuk dari pelanggan, keluar dari supplier
            $table->enum('status_pergantian', ['diganti', 'tidak_diganti', 'diperbaiki']); // retur ganti barang, tidak diganti atau perbaikan
            $table->text('image')->nullable();
            $table->text('path')->nullable();
            $table->text('alasan'); // alasan retur
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
