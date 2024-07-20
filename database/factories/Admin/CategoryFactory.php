<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ($slug = $this->faker->unique()->text(10)),
            'slug' => Str::of($slug)->slug(),
            'is_featured' => $this->faker->numberBetween(1, 0),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Category $category) {
            if ($category->name == 'Fruit') $categoryImage = 'fruits.png';
            if ($category->name == 'Baked Goods')   $categoryImage = 'bake.png';
            if ($category->name == 'Spices')    $categoryImage = 'grains.png';
            if ($category->name == 'Vegetables')    $categoryImage = 'vegetables.png';
            if ($category->name == 'Meat & Poultry')    $categoryImage = 'meat1.png';

            return $category
                ->copyMedia(
                    storage_path('data/'.$categoryImage)
                )
                ->preservingOriginal()
                ->withCustomProperties(['primary' => true, 'position' => 1])
                ->toMediaCollection(get_class($category));
        });
    }
}
