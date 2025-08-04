<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'bio' => $this->faker->paragraph(),
        'avatar_url' => $this->faker->imageUrl(),
        'skills' => Arr::random(['Laravel', 'Vue', 'PHP', 'React', 'CSS', 'HTML'], 2),
        ];
    }
}
