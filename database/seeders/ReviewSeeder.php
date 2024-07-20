<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::factory()
            ->for(User::factory())
            ->for(
                Product::factory()
                    ->for(User::factory())
            )
            ->for(
                Order::factory()
                    ->for(Cart::factory()
                        ->for(User::factory()))
            )
            ->count(1)
            ->create();
    }
}
