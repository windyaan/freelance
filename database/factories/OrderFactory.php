<?php

namespace Database\Factories;
use App\Models\Offer;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        'offer_id' => Offer::factory(),
        'amount' => $this->faker->randomFloat(2, 500, 10000),
        'payment_method' => $this->faker->randomElement(['transfer', 'gopay', 'ovo']),
        'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
