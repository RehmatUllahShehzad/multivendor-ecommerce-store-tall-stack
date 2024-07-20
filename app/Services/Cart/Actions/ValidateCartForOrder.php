<?php

namespace App\Services\Cart\Actions;

use App\Exceptions\Carts\BillingAddressMissingException;
use App\Exceptions\Carts\OrderExistsException;
use App\Exceptions\Carts\ShippingAddressMissingException;
use App\Models\Cart;

class ValidateCartForOrder
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

        // Does this cart already have an order?
        if ($cart->order) {
            throw new OrderExistsException(
                _('exceptions.carts.order_exists')
            );
        }

        // Do we have a billing address?
        if (! $cart->billingAddress) {
            throw new BillingAddressMissingException(
                __('exceptions.carts.billing_missing')
            );
        }

        // Is this cart shippable and if so, does it have a shipping address.
        if (! $cart->shippingAddress) {
            throw new ShippingAddressMissingException(
                __('exceptions.carts.shipping_missing')
            );
        }

        // Check if the product belongs to his own vendor
        app(ValidateVendor::class)->execute($cart);

        // Decrease quantity after order
        app(UpdateQuantity::class)->execute($cart);
    }
}
