<?php

namespace Database\Factories\StokBarang;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Barang\BarangModel;
use App\Models\StokBarang\StokBarangModel;
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
            'id_stok'    => (string) Str::ulid(),
            'id_barang'    => BarangModel::factory(),
            'kode_stok'    => StokBarangModel::generateCodeStock(),
            'no_warehouse'    => StokBarangModel::noWarehouse(),
            'tanggal'    => fake()->dateTimeBetween('-3 days', 'now')->format('Y-m-d'),
            'jumlah_barang'    => fake()->randomDigit(),
            'lokasi'    => fake()->randomElement(['gudang-1', 'gudang-2']),
        ];
    }
}
