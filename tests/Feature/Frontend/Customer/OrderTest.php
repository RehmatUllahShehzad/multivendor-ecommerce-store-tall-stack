<?php

namespace Tests\Feature\Frontend\Customer;

use App\Http\Livewire\Frontend\Customer\Orders\OrderIndexController;
use App\Http\Livewire\Frontend\Customer\Orders\OrderShowController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vendor;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class OrderTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_access_customer_order_listing_page()
    {
        $response = $this->get(route('customer.orders.index'));
        $response->assertRedirect(
            route('login')
        );
    }

    public function test_authorized_customers_can_access_order_listing_page()
    {
        $this->loginUser();
        $response = $this->get(route('customer.orders.index'));
        $response->assertOk();
    }

    public function test_authorized_customers_can_view_all_of_his_orders()
    {
        $user = User::factory()->create();

        Order::factory()
            ->for(Cart::factory()->for(User::factory()))
            ->count(5)
            ->create();

        Livewire::actingAs($user)
            ->test(OrderIndexController::class)
            ->call('render')
            ->assertOk();
    }

    public function test_un_authorized_user_cannot_access_show_order_detail_component()
    {
        Livewire::test(OrderShowController::class)
            ->assertUnauthorized();
    }

    public function test_authorized_customers_can_view_detail_of_each_single_order()
    {
        $this->loginUser();

        $order = Order::factory()
            ->for(Cart::factory()->for(User::factory()))
            ->has(Transaction::factory())
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($order->customer)
            ->test(OrderShowController::class, [
                'order' => $order,
            ])->call('render');

        $response->assertOk();
        $this->assertCount(
            1,
            Order::query()->where('order_number', $order->order_number)->get()
        );
    }

    public function test_customer_can_contact_vendor()
    {
        $this->loginUser();

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

        $response = Livewire::actingAs($user);

        $response = $this->get(route('customer.message.show', $orderPackage));

        $response->assertOk();
    }
}
