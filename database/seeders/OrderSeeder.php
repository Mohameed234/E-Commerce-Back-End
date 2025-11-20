<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::truncate();

        Order::create([
            'order_number' => 'ORD-TEST123',
            'address' => 'Cairo, Egypt',
            'phone' => '0123456789',
            'total' => 35000,
        ]);
    }
}
