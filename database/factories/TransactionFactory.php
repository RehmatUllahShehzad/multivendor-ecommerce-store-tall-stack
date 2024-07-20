<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'success' => true,
            'type' => $this->faker->boolean(85) ? 'capture' : 'refund',
            'driver' => 'stripe payment',
            'amount' => 100,
            'reference' => $this->faker->unique()->regexify('[A-Z]{8}'),
            'status' => 'settled',
            'notes' => null,
            'name_on_card' => $this->faker->name(),
            'expiry_month' => $this->faker->month(),
            'expiry_year' => $this->faker->year(),
            'card_type' => $this->faker->creditCardType,
            'last_four' => $this->faker->numberBetween(1000, 9999),
        ];
    }
}
