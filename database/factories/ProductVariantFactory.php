<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
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
            'sku' => strtoupper(fake()->unique()->bothify('VAR-####-????')),
            'name' => fake()->colorName() . ' - ' . fake()->randomElement(['S', 'M', 'L', 'XL']),
            'options' => json_encode(['color' => fake()->safeColorName(), 'size' => fake()->randomElement(['S', 'M', 'L', 'XL'])]),
            'price' => fake()->randomFloat(2, 10, 300),
            'compare_price' => fake()->optional()->randomFloat(2, 10, 300),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'stock_status' => 'in_stock',
            'is_active' => true,
        ];
    }
}
