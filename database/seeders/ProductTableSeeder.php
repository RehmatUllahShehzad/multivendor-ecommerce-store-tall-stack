<?php

namespace Database\Seeders;

use App\Models\Admin\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    public Product $public;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(1)
            ->has(
                Product::factory(10)
                    ->has(Category::factory(1))
            )
            ->has(
                Vendor::factory(1)
            )
            ->create();

        $this->command->info('Products Seeded');
    }
}
