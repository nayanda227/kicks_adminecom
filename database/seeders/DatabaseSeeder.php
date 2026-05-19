<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // TAMBAHKAN BARIS INI:
        $this->call([
            OrderSeeder::class,
            
        ]);
    }
}