<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::factory()
            ->for(Conversation::factory()
                ->for(OrderPackage::factory()
                    ->for(Vendor::factory())
                    ->for(Order::factory()
                        ->for(Cart::factory()
                            ->for(User::factory())))))
            ->for(User::factory(), 'sender')
            ->for(User::factory(), 'receiver')
            ->count(1)
            ->create();
    }
}
