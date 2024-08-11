<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'content' => fake()->text(1000),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'created_at' => fake()->dateTime(),
            'views' => fake()->numberBetween(0, 1000),
            'status' => 'Accept',
        ];
    }
}
