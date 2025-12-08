<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sub = fake()->randomFloat(2, 30, 400);
        return [
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'customer_id' => \App\Models\Customer::factory(),
            'coupon_id' => null,
            'subtotal' => $sub,
            'discount_amount' => 0,
            'shipping_cost' => fake()->randomFloat(2, 0, 15),
            'tax_amount' => fake()->randomFloat(2, 0, 20),
            'total' => $sub,
            'shipping_full_name' => fake()->name(),
            'shipping_phone' => fake()->phoneNumber(),
            'shipping_address_line_1' => fake()->streetAddress(),
            'shipping_address_line_2' => fake()->optional()->secondaryAddress(),
            'shipping_city' => fake()->city(),
            'shipping_state' => fake()->optional()->state(),
            'shipping_postal_code' => fake()->postcode(),
            'shipping_country' => 'US',
            'payment_method' => fake()->randomElement(['stripe', 'cash_on_delivery']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'tracking_number' => fake()->optional()->uuid(),
            'customer_notes' => fake()->optional()->sentence(),
            'admin_notes' => fake()->optional()->sentence(),
        ];
    }
}
