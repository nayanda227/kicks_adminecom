<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;     // <-- 1. Import Order
use App\Models\OrderItem; // <-- 2. Import OrderItem 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Ambil ID user secara acak dari tabel users
            'user_id' => User::inRandomOrder()->first()->id, 
            
            // Buat nomor order unik palsu
            'order_number' => '#' . fake()->unique()->numberBetween(100000, 999999),
            
            // Buat total harga palsu (2 desimal, min $20, max $1000)
            'total_amount' => fake()->randomFloat(2, 20, 1000), 
            
            // Pilih status secara acak
            'status' => fake()->randomElement(['Delivered', 'Canceled', 'Pending']),
            
            // Buat tanggal palsu (biar datanya bervariasi)
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    public function configure(): static
    {
        // 'afterCreating' akan jalan SETELAH order-nya dibuat
        return $this->afterCreating(function (Order $order) {
            
            // Buat 1 sampai 3 'OrderItem' palsu
            // dan otomatis sambungkan 'order_id'-nya
            OrderItem::factory()
                ->count(fake()->numberBetween(1, 3)) 
                ->create([
                    'order_id' => $order->id,
                ]);
        });
    }
}