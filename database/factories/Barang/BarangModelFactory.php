<?php

namespace Database\Factories\Barang;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang\BarangModel>
 */
class BarangModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_barang'    => (string) Str::ulid(),
            'kode_barang'  => (string) Str::random(10),
            'nama_barang'  => fake()->name(),
            'jenis'  =>  fake()->name(),
            'merek'  =>  fake()->name(),
            'tipe_model' => fake()->word(),
            'serial_number'    => (string) Str::random(15),
            'satuan'    => fake()->randomDigit(),
            'keterangan'    => fake()->sentence(),

        ];
    }
}
