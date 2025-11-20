<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate();

        Product::insert([
            [
                'name' => 'Laptop HP',
                'description' => 'High performance laptop',
                'price' => 15000,
                'quantity' => 10,
                'sku' => 'HP-123',
                'is_active' => 1,
            ],
            [
                'name' => 'iPhone 14',
                'description' => 'Latest model',
                'price' => 32000,
                'quantity' => 20,
                'sku' => 'IP-001',
                'is_active' => 1,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable mini speaker',
                'price' => 500,
                'quantity' => 50,
                'sku' => 'SP-901',
                'is_active' => 1,
            ],
        ]);
    }
}
