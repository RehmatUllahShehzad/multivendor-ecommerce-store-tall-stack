<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderPackage>
 */
class OrderPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $total = $this->faker->numberBetween(200, 25000);

        return [
            'service_fee' => rand(50, 500),
            'type' => $this->faker->randomElement(['pickup', 'standard_delivery', 'express_delivery']),
            'sub_total' => $total - 50,
            'shipping_fee' => 200,
            'status' => 'processing',
            'tracking_number' => uniqid('abc'),
            'meta' => [
                'bio' => $this->faker->text(500),
            ],
        ];
    }
}
