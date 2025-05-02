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
            $table->uuid('id_barang_masuk')->primary();
            $table->foreignUuid('id_barang')->constrained('tb_barang', 'id_barang')->cascadeOnDelete();
            $table->foreignUuid('id_supplier')->nullable()->constrained('tb_supplier', 'id_supplier')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('sumber', ['internal', 'supplier'])->default('internal');
            $table->string('pembeli', 50)->nullable();
            $table->string('nota', 50);
            $table->integer('jumlah');
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
