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
        $amount = $this->faker->randomFloat(2, 500, 10000);

        // Simulasi pembayaran: belum bayar, DP, full, atau gagal
        $case = $this->faker->randomElement(['pending', 'dp', 'paid', 'failed']);

        $amountPaid = match ($case) {
            'pending' => 0,
            'dp'      => $this->faker->randomFloat(2, 1, $amount - 1), // kurang dari total
            'paid'    => $amount,
            'failed'  => 0, // gagal = tidak tercatat bayar
        };

        return [
        'offer_id'       => Offer::factory(),
            'amount'         => $amount,
            'amount_paid'    => $amountPaid,
            'payment_method' => $this->faker->randomElement(['transfer', 'gopay', 'ovo']),
            'status'         => $case,
        ];
    }
}
