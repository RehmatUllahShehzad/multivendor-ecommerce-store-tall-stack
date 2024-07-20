<?php

namespace App\Contracts;

use App\Models\Cart;
use Illuminate\Contracts\Auth\Authenticatable;

/** @mixin \App\Services\Cart\CartManager */
interface CartSessionInterface
{
    /**
     * Return the current cart.
     *
     * @return \App\Models\Cart|null
     */
    public function current();

    /**
     * Forget the current cart session.
     *
     * @return void
     */
    public function forget();

    /**
     * Return the cart manager instance.
     *
     * @return \App\Services\Cart\CartManager
     */
    public function manager();

    /**
     * Associate a cart to a user.
     *
     * @param  \App\Models\Cart  $cart
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $policy
     * @return void
     */
    public function associate(Cart $cart, Authenticatable $user, $policy);

    /**
     * Use the given cart and set to the session.
     *
     * @param  \App\Models\Cart  $cart
     * @return void
     */
    public function use(Cart $cart);

    /**
     * Return the session key for carts.
     *
     * @return string
     */
    public function getSessionKey();

    public function totalQuantity();
}
