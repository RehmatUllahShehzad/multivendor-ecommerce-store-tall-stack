<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Contracts\CartSessionInterface;
use Livewire\Component;

class Counter extends Component
{
    /**
     * The event listeners
     *
     * @var array
     */
    protected $listeners = [
        'added-to-cart' => 'render',
        'removed-from-cart' => 'render',
        'cart-updated' => 'render',
        'cart-cleared' => 'render',
    ];

    /**
     * Return the total items in the cart.
     *
     * @return int
     */
    public function getTotalCartItemsProperty(CartSessionInterface $cartSessionManager)
    {
        return $cartSessionManager->totalQuantity();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.cart.counter');
    }
}
