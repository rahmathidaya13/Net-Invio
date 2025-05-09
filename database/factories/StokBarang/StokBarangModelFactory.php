<?php

namespace Database\Factories\StokBarang;

use App\Models\Barang\BarangModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StokBarang\StokBarangModel>
 */
class StokBarangModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_stok'    => (string) Str::uuid(),
            'id_barang'    => BarangModel::factory(),
            'tanggal'    => fake()->date('Y-m-d', 'now'),
            'jumlah_barang'    => fake()->randomDigit(),
            'lokasi'    => fake()->randomElement(['gudang-1', 'gudang-2']),
        ];
    }
}
