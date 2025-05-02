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
            $table->uuid('id_barang')->primary();
            $table->string('kode_barang', 50);
            $table->string('jenis', 50);
            $table->string('merek', 50);
            $table->string('tipe_model', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->string('satuan', 50);
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
        Schema::dropIfExists('tb_barang');
    }
};
