<?php

namespace App\Http\Livewire\Frontend\Shared;

use App\Contracts\CartSessionInterface;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToCartButton extends Component
{
    public Product $product;

    /**
     * The class to use for button
     *
     * @var null
     */
    public bool $showViewCart = false;

    public bool $addSearchClass = false;

    public int $quantity = 1;

    /**
     * Add the attached purchasable to cart
     *
     * @return void
     */
    public function render(): View
    {
        return view('frontend.shared.add-to-cart-button');
    }

    public function addToCart(CartSessionInterface $cartSessionManager)
    {
        try {
            if (Auth::check() && $this->product->isOwnedBy(Auth::user())) {
                $this->emit('alert-danger', trans('notifications.product.cannot-order-alert'));

                return;
            }

            $cartSessionManager->add($this->product, $this->quantity);

            $this->emit('added-to-cart');

            $this->emit('alert-success', trans('product.added_to_cart'));
        } catch (Exception $ex) {
            $this->emit('alert-danger', $ex->getMessage());
        }
    }
}
