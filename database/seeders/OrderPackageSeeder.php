<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class OrderPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderPackage::factory()
            ->for(Vendor::factory([
                'deliver_products' => 1,
            ]))
            ->for(Order::factory()
                ->for(Cart::factory()->for(User::factory()))
            )
            ->count(2)
            ->create();
    }
}
