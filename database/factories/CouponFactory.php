<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('??##??##')),
            'type' => fake()->randomElement(['fixed', 'percentage']),
            'value' => fake()->randomFloat(2, 5, 50),
            'minimum_order_value' => fake()->optional()->randomFloat(2, 20, 100),
            'maximum_discount' => fake()->optional()->randomFloat(2, 30, 150),
            'usage_limit' => fake()->optional()->numberBetween(50, 500),
            'usage_limit_per_customer' => fake()->optional()->numberBetween(1, 3),
            'starts_at' => now()->subDays(rand(0, 10)),
            'expires_at' => now()->addDays(rand(10, 60)),
            'is_active' => true,
        ];
    }
}
