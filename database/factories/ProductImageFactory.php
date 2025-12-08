<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'product_variant_id' => null,
            'image_path' => 'products/' . fake()->uuid() . '.jpg',
            'alt_text' => fake()->optional()->sentence(),
            'is_primary' => false,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
