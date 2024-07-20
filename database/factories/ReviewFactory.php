<?php

namespace Database\Factories;

use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'rating' => rand(1, 5),
            'comment' => $this->faker->text(),
            'status' => 'pending',
            'vendor_reply' => 'Blanditiis numquam c',
            'is_new' => 0,
        ];
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => ReviewStatus::APPROVED,
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => ReviewStatus::REJECTED,
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => ReviewStatus::PENDING,
            ];
        });
    }
}
