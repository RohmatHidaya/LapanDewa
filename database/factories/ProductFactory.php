<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'harga' => fake()->randomNumber(5, true),
            'stok' => fake()->numberBetween(1, 100),
            'barcode' => fake()->isbn13(),
            'expired' => fake()->dateTimeBetween('now', '+10 weeks'),
            'is_active' => true,
        ];
    }
}
