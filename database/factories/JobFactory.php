<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{

    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'freelancer_id' => User::factory(), // atau isi manual nanti saat seeding
            'category_id' => Category::inRandomOrder()->first()?->id,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'starting_price' => $this->faker->randomFloat(2, 50, 1000),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
