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
        Schema::create('tb_supplier', function (Blueprint $table) {
            $table->uuid('id_supplier')->primary();
            $table->string('nama', 50); // nama supplier
            $table->string('kontak', 13); // kontak supplier
            $table->string('email', 50)->unique(); // email supplier jika ada
            $table->string('alamat', 200); // alamat supplier
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_supplier');
    }
};
