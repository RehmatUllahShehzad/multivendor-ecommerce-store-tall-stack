<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cart::factory()
            ->for(User::factory()
                ->has(Address::factory()
                    ->for(
                        State::factory()
                            ->for(Country::factory())
                    )))
            ->count(1)
            ->create();
    }
}
