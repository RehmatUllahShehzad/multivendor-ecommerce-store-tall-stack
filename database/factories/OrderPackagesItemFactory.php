<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderPackagesItem>
 */
class OrderPackagesItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(1000, 5000),
            'meta' => [
                'order_name' => $this->faker->name(),
            ],
        ];
    }
}
