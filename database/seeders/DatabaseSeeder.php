<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Database\Factories\ProductFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        // Transaction::factory(10)->recycle(
        //     User::all(),
        //     User::factory(5)->create(),
        //     Product::factory(5)->create(),
        // )->create();

        // User::all();
        // Product::factory(10)->create();

    }
}
