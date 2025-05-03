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
        Schema::create('tb_pelanggan', function (Blueprint $table) {
            $table->uuid('id_pelanggan')->primary();
            $table->string('nama', 50); // nama pelanggan
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']); // jenis kelamin pelenggan
            $table->string('nohp', 13); //  nomor handphone
            $table->string('email', 50)->nullable()->unique(); // email jika ada
            $table->string('alamat', 150); // alamat pelanggan
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pelanggan');
    }
};
