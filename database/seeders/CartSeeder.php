<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        Cart::truncate();

        Cart::insert([
            [
                'user_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
            ],
            [
                'user_id' => 1,
                'product_id' => 2,
                'quantity' => 1,
            ],
        ]);
    }
}
