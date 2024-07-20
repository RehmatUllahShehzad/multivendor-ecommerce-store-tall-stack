<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\OrderPackagesItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class OrderPackagesItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();

        OrderPackagesItem::factory()
            ->for(
                OrderPackage::factory()
                    ->for(Vendor::factory()->create([
                        'deliver_products' => 120,
                    ]))
                    ->for(Order::factory()
                        ->for(Cart::factory()->for(User::factory()))
                        )
            )->for(Product::factory()
                ->create([
                    'user_id' => $user->id,
                ]))
            ->count(2)
            ->create();
    }
}
