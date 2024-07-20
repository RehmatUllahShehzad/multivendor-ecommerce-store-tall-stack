<?php

namespace App\Services\Cart\Actions;

use App\Contracts\CartSessionInterface;
use App\Exceptions\Carts\QuantityExceedException;
use App\Models\Cart;

class ValidateQuantity
{
    /**
     * Execute the action.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function execute(
        Cart $cart
    ) {
        $cart
            ->items
            ->filter(function ($item) {
                if ($item->quantity <= $item->product->available_quantity) {
                    return false;
                }

                $cartSessionManager = app(CartSessionInterface::class);

                $cartSessionManager->removeItem($item->id);

                return true;
            })
            ->count() > 0
            && throw new QuantityExceedException(
                __('exceptions.product_quantity_exceed')
            );
        }
}
