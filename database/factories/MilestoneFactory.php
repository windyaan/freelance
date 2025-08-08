<?php

namespace Database\Factories;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Milestone>
 */
class MilestoneFactory extends Factory
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
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'status' => $this->faker->randomElement(['Start', 'Progress', 'Done', 'revisi_request', 'approved']),
        'completed_at' => now(),
        ];
    }
}
