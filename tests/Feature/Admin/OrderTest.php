<?php

namespace Tests\Feature\Admin;

use App\Http\Livewire\Admin\Order\OrderIndexController;
use App\Http\Livewire\Admin\Order\OrderShowController;
use App\Models\Cart;
use App\Models\CartAddress;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\State;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vendor;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class OrderTest extends TestCase
{
    use WithLogin;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
    }

    public function test_authorized_admin_can_see_order_listing_page(): void
    {
        $this->loginStaff();

        $response = Livewire::test(OrderIndexController::class)
            ->call('render');

        $response->assertOk();
    }

    public function test_authorized_admin_can_view_all_of_his_orders()
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

    public function test_admin_can_search_order_by_price_order_id_customer_name()
    {
        $user = User::factory()->create();

        $orderPackage = OrderPackage::factory()
            ->for(Vendor::factory([
                'deliver_products' => 1,
            ]))
            ->for(
                Order::factory()
                    ->for(Cart::factory()->for(User::factory()))
            )
            ->count(3)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(OrderIndexController::class)
            ->set('search', $orderPackage->user->first_name)
            ->set('range', [
                'from' => $orderPackage->created_at,
                'to' => $orderPackage->created_at,
            ]);

        $response->assertSee($orderPackage->user->first(1)->first_name);
        $response->assertDontSee($orderPackage->user->first(2)->first_name);

        $response = Livewire::actingAs($user)
            ->test(OrderIndexController::class)
            ->set('search', $orderPackage->order->order_number)
            ->set('range', [
                'from' => $orderPackage->created_at,
                'to' => $orderPackage->created_at,
            ]);

        $response->assertSee($orderPackage->order->first(1)->order_number);
        $response->assertDontSee($orderPackage->order->first(2)->order_number);

        $response = Livewire::actingAs($user)
            ->test(OrderIndexController::class)
            ->set('search', $orderPackage->order->total_amount)
            ->set('range', [
                'from' => $orderPackage->created_at,
                'to' => $orderPackage->created_at,
            ]);

        $response->assertSee($orderPackage->order->first(1)->total_amount);
        $response->assertDontSee($orderPackage->order->first(2)->total_amount);

        $response = Livewire::actingAs($user)
            ->test(OrderIndexController::class)
            ->set('search', 'invalid records');

        $response->assertSee('');
    }

    public function test_authorized_admin_can_view_detail_of_each_single_order()
    {
        $this->loginStaff();

        $order = Order::factory()
            ->has(OrderPackage::factory()
                ->for(Vendor::factory([
                    'deliver_products' => 1,
                ])), 'packages')
            ->for(
                Cart::factory()
                    ->for(User::factory())
                    ->has(
                        CartAddress::factory()
                            ->shipping()
                            ->for(State::factory()
                                ->for(Country::factory())),
                        'shippingAddress'
                    )
                    ->has(
                        CartAddress::factory()
                            ->billing()
                            ->for(State::factory()
                                ->for(Country::factory())),
                        'billingAddress'
                    )
            )
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

    public function test_admin_can_view_relevant_customer()
    {
        $this->loginStaff();

        $order = Order::factory()
            ->has(OrderPackage::factory()
                ->for(Vendor::factory([
                    'deliver_products' => 1,
                ])), 'packages')
            ->for(
                Cart::factory()
                    ->for(User::factory())
                    ->has(
                        CartAddress::factory()
                            ->shipping()
                            ->for(State::factory()
                                ->for(Country::factory())),
                        'shippingAddress'
                    )
                    ->has(
                        CartAddress::factory()
                            ->billing()
                            ->for(State::factory()
                                ->for(Country::factory())),
                        'billingAddress'
                    )
            )
            ->has(Transaction::factory())
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::test(OrderShowController::class, [
            'order' => $order,
        ])->call('render');

        $response = $this->get(route('admin.order.show', $order->customer));

        $response->assertOk();

        $response->assertSee($order->customer->first_name);
        $response->assertSee($order->customer->last_name);
    }
}
