<?php

namespace Database\Factories\Pelanggan;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan\PelangganModel>
 */
class PelangganModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pelanggan'    =>  Str::ulid(),
            'no_identitas'  => Str::random(15),
            'tanggal'  => fake()->date('Y-m-d', 'now'),
            'nama'  =>  fake()->name(),
            'jenis_kelamin'  =>  fake()->randomElement(['laki-laki', 'perempuan']),
            'nohp' => fake()->numerify('08###########'),
            'email'    => fake()->unique()->email(),
            'alamat'    =>  fake()->address(),
        ];
    }
}
