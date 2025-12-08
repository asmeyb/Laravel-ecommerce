<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'brand_id' => fake()->optional()->randomElement(\App\Models\Brand::pluck('id')->toArray()),
            'name' => fake()->unique()->words(3, true),
            'slug' => fake()->unique()->slug(),
            'sku' => strtoupper(fake()->unique()->bothify('SKU-####-????')),
            'short_description' => fake()->optional()->sentence(),
            'description' => fake()->optional()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 10, 300),
            'compare_price' => fake()->optional()->randomFloat(2, 10, 300),
            'cost_price' => fake()->optional()->randomFloat(2, 5, 100),
            'stock_quantity' => fake()->numberBetween(0, 200),
            'low_stock_threshold' => 10,
            'manage_stock' => true,
            'stock_status' => 'in_stock',
            'is_active' => true,
            'is_featured' => fake()->boolean(),
            'has_variants' => false,
            'weight' => fake()->optional()->randomFloat(2, 0.1, 10),
            'meta_title' => fake()->optional()->sentence(),
            'meta_description' => fake()->optional()->paragraph(),
        ];
    }
}
