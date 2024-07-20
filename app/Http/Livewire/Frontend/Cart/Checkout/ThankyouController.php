<?php

namespace App\Http\Livewire\Frontend\Cart\Checkout;

use App\Contracts\CartSessionInterface;
use App\Http\Livewire\Frontend\Cart\CartIndexController;
use App\Models\Order;
use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ThankyouController extends CartIndexController
{
    /**
     * The order model
     *
     * @var \App\Models\Order
     */
    public Order $order;

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount()
    {
        if (! isset($this->cart->order)) {
            return to_route('homepage');
        }

        $this->order = $this->cart->order;

        $cartSessionManager = app(CartSessionInterface::class);

        $cartSessionManager->forget();
    }

    public function render(): View
    {
        return view('frontend.cart.checkout.thankyou-controller')->layout(MasterLayout::class, [
            'title' => trans('global.checkout.payment-method'),
            'description' => trans('global.checkout.payment-method'),
        ]);
    }
}
