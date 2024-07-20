<?php

namespace App\Services\Cart\Actions;

use App\Enums\OrderStatus;
use App\Facades\SettingFacade;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderPackage;
use App\Models\OrderPackagesItem;
use App\Services\Cart\OrderModifiers;
use App\Services\Cart\OrderReferenceGenerator;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class CreateOrder
{
    protected $referenceGenerator;

    public function __construct(OrderReferenceGenerator $generator)
    {
        $this->referenceGenerator = $generator;
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function execute(
        Cart $cart
    ) {
        app(ValidateCartForOrder::class)->execute($cart);

        // If the cart total is null, we haven't calculated it, so do that.
        $cart->getManager()->calculate();

        return DB::transaction(function () use ($cart) {
            $pipeline = app(Pipeline::class)
                ->send($cart)
                ->through(
                    $this->getModifiers()->toArray()
                );

            $cart = $pipeline->via('creating')->thenReturn();
            $order = Order::create([
                'cart_id' => $cart->id,
                'total_amount' => ($cart->subTotal + $cart->shippingTotal),
                'payment_method_id' => $cart->meta->payment_method_id,
                'meta' => $cart->meta,
            ]);

            $order->update([
                'order_number' => $this->referenceGenerator->generate($order),
            ]);

            $orderPackages = $cart
                ->items
                ->map(fn ($item) => [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'vendor_id' => $item->product->user_id,
                    'price' => $item->product->price,
                    'sub_total' => $item->subTotal,
                ])->groupBy('vendor_id');
            foreach ($orderPackages as $key => $package) {
                $shipping = collect($cart->meta->shippingOptions)->where('vendor_id', $key)->first();
                $orderPackage = OrderPackage::create([
                    'vendor_id' => $key,
                    'order_id' => $order->id,
                    'service_fee' => (SettingFacade::get('service_fee') / 100) * (collect($package)->sum('sub_total')),
                    'shipping_fee' => $shipping ? $shipping->value : 0,
                    'sub_total' => collect($package)->sum('sub_total'),
                    'type' => $shipping->type,
                    'status' => OrderStatus::Processing,
                    'meta' => $cart->meta,
                ]);

                foreach ($package as $item) {
                    OrderPackagesItem::create([
                        'order_package_id' => $orderPackage->id,
                        'product_id' => $item['product_id'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'meta' => '',
                    ]);
                }
            }

            $cart->load('order');

            return $pipeline->send($order)->via('created')->thenReturn();
        });
    }

    /**
     * Return the cart modifiers.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getModifiers()
    {
        return app(OrderModifiers::class)->getModifiers();
    }
}
