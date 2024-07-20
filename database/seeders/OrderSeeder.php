<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()
            ->for(Cart::factory()->for(User::factory()))
            ->count(1)
            ->create();
    }
}
