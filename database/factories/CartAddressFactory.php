<?php

namespace Database\Factories;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartAddress>
 */
class CartAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'company_name' => $this->faker->boolean ? $this->faker->company : null,
            'address_1' => $this->faker->streetName,
            'address_2' => $this->faker->streetName,
            'city' => $this->faker->city,
            'zip' => $this->faker->postcode,
            'delivery_instructions' => $this->faker->boolean ? $this->faker->sentence : null,
            'phone' => $this->faker->boolean ? $this->faker->phoneNumber : null,
            'type' => 'shipping',
            'meta' => $this->faker->boolean ? ['has_dog' => 'yes'] : null,
        ];
    }

    public function shipping()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => AddressType::SHIPPING,
            ];
        });
    }

    public function billing()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => AddressType::BILLING,
            ];
        });
    }
}
