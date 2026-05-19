<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product; // <-- 1. Import Product
use App\Models\Order;   // <-- 2. Import Order

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Ambil 1 produk acak dari database
        $product = Product::inRandomOrder()->first();

        return [
            // nggak perlu 'order_id' di sini, 
            // karena 'OrderFactory' akan ngasih
            
            'product_id' => $product->id,
            'quantity' => fake()->numberBetween(1, 3),
            'price' => $product->price // Ambil harga asli produknya
        ];
    }
}