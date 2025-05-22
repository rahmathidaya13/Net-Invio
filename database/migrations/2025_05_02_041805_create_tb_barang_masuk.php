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
        Schema::create('tb_barang_masuk', function (Blueprint $table) {
            $table->ulid('id_barang_masuk')->primary();
            $table->foreignUuid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete(); // ambil barang dengan relasi tb barang
            $table->foreignUuid('id_supplier')->nullable()->constrained('tb_supplier', 'id_supplier')->cascadeOnDelete(); // ambil supplier dengan relasi tb supplier jika ada
            $table->date('tanggal'); // tanggal barang masuk atau barang dibeli
            $table->string('no_warehouse', 50); // No Warehouse
            $table->enum('sumber', ['internal', 'supplier'])->default('internal'); // sumber barang masuk dibeli atau dari supplier
            $table->string('pembeli', 50)->nullable(); // jika pembeli petugas atau karyawan (nama orang)
            $table->string('nota', 50); // Bisa disimpan sebagai kode transaksi atau file
            $table->integer('jumlah'); // jumlah barang masuk
            $table->decimal('harga', 12, 2)->default(0);
            $table->string('lokasi', 50); // lokasi barang masuk
            $table->text('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang_masuk');
    }
};
