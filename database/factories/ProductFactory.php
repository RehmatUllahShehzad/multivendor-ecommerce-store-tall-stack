<?php

namespace Database\Factories;

use App\Models\Admin\Nutrition;
use App\Models\Admin\Unit;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => ($slug = $this->faker->unique()->text(50)),
            'slug' => Str::of($slug)->slug(),
            'description' => $this->faker->text(200),
            'attributes' => $this->faker->text(200),
            'ingredients' => $this->faker->text(200),
            'available_quantity' => $this->faker->numberBetween(1, 1000),
            'unit_id' => $this->faker->numberBetween(1, 3),
            'price' => $this->faker->numberBetween(100, 1000),
            'is_featured' => $this->faker->boolean(),
            'is_published' => $this->faker->boolean(),
            'user_id' => $this->faker->text(200),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->copyMedia(
                storage_path('data/sample.jpg')
            )->usingName($this->faker->text(50))
                ->withCustomProperties(['primary' => true, 'position' => 1])
                ->toMediaCollection(get_class($product));

            if (! empty($nutritions = $this->createNutritions($product))) {
                $product->nutritions()->sync($nutritions);
            }
        });
    }

    public function createNutritions(Product $product)
    {
        $nutritions = Nutrition::factory()->count(3)->create();
        $units = Unit::factory()->count(3)->create();

        /** @var array<mixed> */
        $attachNutritions = [];
        foreach (array_combine($nutritions->pluck('id')->toArray(), $units->pluck('id')->toArray()) as $key => $value) {
            $attachNutritions[$key] = [
                'unit_id' => $value,
                'value' => rand(10, 90),
            ];
        }

        return $attachNutritions;
    }
}
