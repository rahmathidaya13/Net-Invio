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
        Schema::create('profile', function (Blueprint $table) {
            $table->ulid('id_profile')->primary();
            $table->foreignUlid('id_user')->constrained('users', 'id')->cascadeOnDelete();
            $table->string('phone', 13)->nullable();
            $table->string('address', 250)->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('image')->nullable(); // bisa simpan path ke foto
            $table->string('position', 50)->nullable(); // jabatan atau peran kerja
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
