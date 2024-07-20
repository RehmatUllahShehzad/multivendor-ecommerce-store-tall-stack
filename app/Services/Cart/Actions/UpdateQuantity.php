<?php

namespace App\Services\Cart\Actions;

use App\Models\Cart;

class UpdateQuantity
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
        app(ValidateQuantity::class)->execute($cart);

        $cart
            ->items
            ->each(function ($item) {
                /** @var \App\Models\Product $product */
                $product = $item->product;
                $product->decrement('available_quantity', $item->quantity);
            });
    }
}
