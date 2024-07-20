<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Conversation;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conversation::factory()
            ->for(
                OrderPackage::factory()
                    ->for(Vendor::factory()->create([
                        'deliver_products' => 120,
                    ]))
                    ->for(Order::factory()
                        ->for(Cart::factory()->for(User::find(1)))
                    )
            )
            ->hasMessages(3)
            ->count(10)
            ->create();
    }
}
