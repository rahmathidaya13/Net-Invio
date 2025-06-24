<?php

namespace Database\Factories\BarangMasuk;

use Illuminate\Support\Str;
use App\Models\Barang\BarangModel;
use App\Models\BarangMasuk\BarangMasukModel;
use App\Models\Supplier\SupplierModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BarangMasuk\BarangMasukModel>
 */
class BarangMasukModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_barang_masuk' => (string) Str::ulid(),
            'id_barang' => BarangModel::factory(),
            'id_supplier' => SupplierModel::factory(),
            'tanggal' => fake()->dateTimeBetween('-3 days', 'now')->format('Y-m-d'),
            'kode_brg_masuk' => BarangMasukModel::generateInBound(),
            'sumber' => fake()->randomElement(['internal', 'supplier']),
            'pembeli' => fake()->name(),
            'nota' => fake()->sentence(3),
            'jumlah' => fake()->numberBetween(1, 100),
            'harga' => fake()->randomFloat(2, 1000, 100000),
            'lokasi' => fake()->randomElement(['gudang-1', 'gudang-2']),
            'keterangan' => fake()->sentence(6),
        ];
    }
}
