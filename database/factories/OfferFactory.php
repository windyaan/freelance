<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Job;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => User::factory()->state(['role' => 'client']),
            'freelancer_id' => User::factory()->state(['role' => 'freelancer']),
            'job_id' => Job::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'final_price' => $this->faker->randomFloat(2, 500, 5000),
            'deadline' => now()->addDays(rand(3, 14)),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'declined']),
        ];
    }
}
