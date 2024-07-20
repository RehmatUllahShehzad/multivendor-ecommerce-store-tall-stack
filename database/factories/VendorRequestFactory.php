<?php

namespace Database\Factories;

use App\Enums\VendorStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendorRequest>
 */
class VendorRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'extra_data' => [
                'bio' => $this->faker->text(500),
                'vendor_name' => $this->faker->name(),
                'company_name' => $this->faker->company,
                'company_address' => $this->faker->address(),
                'company_phone' => $this->faker->phoneNumber(),
            ],
        ];
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => VendorStatus::Approved,
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => VendorStatus::Rejected,
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => VendorStatus::Pending,
            ];
        });
    }
}
