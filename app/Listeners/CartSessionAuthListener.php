<?php

namespace App\Listeners;

use App\Contracts\CartSessionInterface;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class CartSessionAuthListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the login event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function login(Login $event)
    {
        if (! $event->user instanceof User) {
            return;
        }

        $currentCart = app(CartSessionInterface::class)->current();

        if ($currentCart && ! $currentCart->user_id) {
            app(CartSessionInterface::class)->associate(
                $currentCart,
                $event->user,
                config('cart.auth_policy')
            );
        }

        if (! $currentCart) {
            // Does this user have a cart?
            $userCart = Cart::whereUserId($event->user->getKey())->active()->first();

            if ($userCart) {
                app(CartSessionInterface::class)->use($userCart);
            }
        }
    }

    /**
     * Handle the logout event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function logout(Logout $event)
    {
        if (! $event->user instanceof User) {
            return;
        }

        app(CartSessionInterface::class)->forget();
    }
}
