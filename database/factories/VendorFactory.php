<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vendor_name' => fake()->name(),
            'vendor_slug' => fake()->slug(),
            'bio' => fake()->text(),
            'company_name' => fake()->company(),
            'company_address' => fake()->address(),
            'company_phone' => '18156912324',
            'is_active' => fake()->boolean(),
            'deliver_products' => fake()->boolean(),
            'deliver_up_to_max_miles' => fake()->numberBetween(1, 50),
            'express_delivery_rate' => fake()->numberBetween(1, 100),
            'standard_delivery_rate' => fake()->numberBetween(1, 50),
        ];
    }
}
