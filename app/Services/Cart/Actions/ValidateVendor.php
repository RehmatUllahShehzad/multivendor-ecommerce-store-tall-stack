<?php

namespace App\Services\Cart\Actions;

use App\Exceptions\Carts\ValidateVendorException;
use App\Models\Cart;
use App\Services\Cart\CartSessionManager;
use Illuminate\Support\Facades\Auth;

class ValidateVendor
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
        $cart->items
            ->filter(function ($item) {
                if (! $item->product->isOwnedBy(Auth::user())) {
                    return false;
                }

                $cartSessionManager = app(CartSessionManager::class);

                $cartSessionManager->removeItem($item->id);

                return true;
            })
            ->count() > 0
            && throw new ValidateVendorException(
                __('exceptions.vendor_validate_alert')
            );
    }
}
