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
        Schema::create('tb_stok', function (Blueprint $table) {
            $table->uuid('id_stok')->primary();
            $table->foreignUuid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete(); // relasi dengan tabel barang
            $table->date('tanggal'); // tanggal dibuat stok
            $table->integer('jumlah_barang'); // total stok tersedia
            $table->string('lokasi', 150)->nullable(); // Misal: Gudang A Atau Rak 1 Dll
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_stok');
    }
};
