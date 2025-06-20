<?php

namespace Database\Factories\Supplier;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier\SupplierModel>
 */
class SupplierModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_supplier' => Str::ulid(),
            'nama' => fake()->company(),
            'kontak' => '08' . fake()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'alamat' => fake()->address(),
        ];
    }
}
