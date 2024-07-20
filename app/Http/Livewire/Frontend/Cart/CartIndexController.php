<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Http\Livewire\Traits\HasCartMethods;
use App\View\Components\Frontend\Layouts\MasterLayout;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CartIndexController extends Component
{
    use HasCartMethods;

    /**
     * Determine if the page is cart or checkout
     *
     * @var bool
     */
    public $isCartPage = true;

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount()
    {
        if (! $this->cartItems->count()) {
            return $this->handleEmptyCart();
        }
    }

    /**
     * Handle the empty cart
     *
     * @return void|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function handleEmptyCart()
    {
        return to_route('products.index');
    }

    public function render(): View
    {
        return view('frontend.cart.cart-index-controller')
            ->layout(MasterLayout::class, [
                'title' => trans('product.product-listing'),
                'description' => trans('product.product-listing'),
            ]);
    }
}
