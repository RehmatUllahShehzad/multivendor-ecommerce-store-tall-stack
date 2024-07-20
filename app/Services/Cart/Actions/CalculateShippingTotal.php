<?php

namespace App\Services\Cart\Actions;

use App\Models\Cart;

class CalculateShippingTotal
{
    public function __construct()
    {
        //
    }

    /**
     * Execute the action.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function execute(Cart $cart)
    {
        return collect($cart->meta?->shippingOptions ?? [])->sum('value');
    }
}
