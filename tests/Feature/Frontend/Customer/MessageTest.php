<?php

namespace Tests\Feature\Frontend\Customer;

use App\Http\Livewire\Frontend\Customer\Message\MessageIndexController;
use App\Http\Livewire\Frontend\Customer\Message\MessageShowController;
use App\Models\Cart;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class MessageTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_access_customer_message_listing_page()
    {
        $response = $this->get(route('customer.messages'));
        $response->assertRedirect(
            route('login')
        );
    }

    public function test_authorized_customers_can_access_message_listing_page()
    {
        $this->loginUser();
        $response = $this->get(route('customer.messages'));
        $response->assertOk();
    }

    public function test_authorized_customers_can_view_all_of_his_messages()
    {
        $user = User::factory()->create();

        Message::factory()
            ->for(Conversation::factory()
                ->for(OrderPackage::factory()
                    ->for(Vendor::factory())
                    ->for(Order::factory()
                        ->for(Cart::factory()
                            ->for(User::factory())))))
            ->for(user::factory(), 'sender')
            ->for(user::factory(), 'receiver')
            ->count(5)
            ->create();

        Livewire::actingAs($user)
            ->test(MessageIndexController::class)
            ->call('render')
            ->assertOk();
    }

    public function test_customer_can_sort_messages_record(): void
    {
        $this->loginUser();

        $user = User::factory()->times(3)->create();

        /** Test Sort By ascending order */
        $response = Livewire::test(MessageIndexController::class)
            ->set('sortBy', 'asc')
            ->call('render');

        $response->assertSeeInOrder([
            $user[0]['ahsan'],
            $user[1]['baber'],
            $user[2]['delia'],
        ]);

        /** Test Sort By descending order */
        $response = Livewire::test(MessageIndexController::class)
            ->set('sortBy', 'desc')
            ->call('render');

        $response->assertSeeInOrder([
            $user[2]['ahsan'],
            $user[1]['baber'],
            $user[0]['delia'],
        ]);
    }

    public function test_customer_cannot_send_message_to_vendor_with_invalid_data()
    {
        $user = User::factory()
            ->count(1)
            ->create()
            ->first();

        $orderPackage = OrderPackage::factory()
            ->for(Vendor::factory([
                'deliver_products' => 1,
            ]))
            ->for(
                Order::factory()
                    ->for(Cart::factory()->for($user))
            )
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(MessageShowController::class, [
                'orderPackage' => $orderPackage,
            ])
            ->set('textMessage', '')
            ->call('sendMessage');
        $response->assertHasErrors('textMessage')
            ->assertStatus(200);
    }

    public function test_customer_can_send_message_to_vendor_with_valid_data()
    {
        $user = User::factory()
            ->count(1)
            ->create()
            ->first();

        $orderPackage = OrderPackage::factory()
            ->for(Vendor::factory([
                'deliver_products' => 1,
            ]))
            ->for(
                Order::factory()
                    ->for(Cart::factory()->for($user))
            )
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(MessageShowController::class, [
                'orderPackage' => $orderPackage,
            ])
            ->set('textMessage', 'test1')
            ->set('file', UploadedFile::fake()->image('avatar.jpg'))
            ->call('sendMessage');
        $response->assertHasNoErrors()
            ->assertStatus(200);

        $this->assertCount(1, Message::where('sender_id', $user->id)->get());
    }
}
