<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->optional()->paragraph(),
            'image' => 'categories/' . fake()->uuid() . '.jpg',
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
            'meta_title' => fake()->optional()->sentence(),
            'meta_description' => fake()->optional()->paragraph(),
        ];
    }
}
