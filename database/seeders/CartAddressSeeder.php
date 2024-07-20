<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartAddress;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CartAddress::factory()
            ->for(
                Cart::factory()
                    ->for(User::factory())
            )
            ->count(1)
            ->create();
    }
}
