<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 100), // Asumsikan ID user acak
            'title' => ucwords(fake()->sentence()),
            'is_done' => rand(0, 1), 
            'category_id' => rand(1, 10),
        ];
    }
}