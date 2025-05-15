<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin1234'),
                'role' => 'admin',
                'can_view' => true,
                'can_add' => true,
                'can_edit' => true,
                'can_delete' => true,
            ],
            [
                'name' => 'develop',
                'email' => 'develop@example.com',
                'password' => bcrypt('develop1234'),
                'role' => 'develop',
                'can_view' => true,
                'can_add' => true,
                'can_edit' => true,
                'can_delete' => true,
            ],
        ];
        foreach ($data as $rows) {
            \App\Models\User::factory()->create($rows);
        }
        // \App\Models\User::factory(10)->create();
        \App\Models\Barang\BarangModel::factory(50)->create();
        \App\Models\Pelanggan\PelangganModel::factory(50)->create();
        \App\Models\StokBarang\StokBarangModel::factory(50)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
