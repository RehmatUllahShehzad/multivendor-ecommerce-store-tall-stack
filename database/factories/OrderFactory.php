<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition()
    {
        $total_amount = $this->faker->numberBetween(200, 25000);

        return [
            'total_amount' => $total_amount,
            'payment_method_id' => rand(5, 50),
            'order_number' => $this->faker->unique()->regexify('[A-Z]{8}'),
            'meta' => [
                'bio' => $this->faker->text(500),
            ],
        ];
    }
}
