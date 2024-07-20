<?php

namespace Database\Seeders;

use App\Models\Admin\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        Category::factory()->createMany([
            [
                'id' => 1,
                'name' => 'Fruit',
                'slug' => 'Fruit',
                'sort_order' => '0',
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Vegetables',
                'slug' => 'Vegetables',
                'sort_order' => '0',
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Meat & Poultry',
                'slug' => 'Meat & Poultry',
                'sort_order' => '0',
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Baked Goods',
                'slug' => 'Baked Goods',
                'sort_order' => '0',
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Spices',
                'slug' => 'Spices',
                'sort_order' => '0',
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
