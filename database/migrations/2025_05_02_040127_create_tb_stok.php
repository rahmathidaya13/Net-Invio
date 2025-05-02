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
            $table->foreignUuid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete();
            $table->date('tanggal');
            $table->integer('jumlah_barang');
            $table->string('lokasi', 50);
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
