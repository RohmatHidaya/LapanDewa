<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'total_price' => $this->faker->numberBetween(10000, 100000),
            'paid_amount' => function (array $attributes) {
                return $attributes['total_price']; 
            },
            'change_amount' => 0,
        ];
    }
}
