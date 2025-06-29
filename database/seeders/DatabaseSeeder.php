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
                'name' => 'Is admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin1234'),
                'role' => 'admin',
                'can_view' => true,
                'can_add' => true,
                'can_edit' => true,
                'can_delete' => true,
                'can_import' => false,
                'can_download' => true,
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
                'can_import' => true,
                'can_download' => true,
            ],
        ];
        foreach ($data as $rows) {
            \App\Models\User::factory()->create($rows);
        }
        // \App\Models\User::factory(10)->create();
        \App\Models\Barang\BarangModel::factory(50)->create();
        \App\Models\Pelanggan\PelangganModel::factory(50)->create();
        \App\Models\StokBarang\StokBarangModel::factory(50)->create();
        // \App\Models\BarangMasuk\BarangMasukModel::factory(50)->create();
        \App\Models\Supplier\SupplierModel::factory(50)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
