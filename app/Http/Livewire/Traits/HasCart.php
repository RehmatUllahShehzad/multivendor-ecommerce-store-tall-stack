<?php

namespace App\Http\Livewire\Traits;

use App\Contracts\CartSessionInterface;

trait HasCart
{
    /**
     * Get the current cart instance.
     *
     * @return \App\Models\Cart|null
     */
    public function getCartProperty(CartSessionInterface $cartSessionManager)
    {
        return $cartSessionManager->current();
    }
}
