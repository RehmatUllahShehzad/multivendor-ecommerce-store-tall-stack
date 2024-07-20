<?php

namespace App\Services\Cart;

use App\Contracts\CartSessionInterface;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Session\SessionManager;

/** @mixin  CartManager */
class CartSessionManager implements CartSessionInterface
{
    private static ?int $totalItems = null;

    public function __construct(
        protected SessionManager $sessionManager,
        protected AuthManager $authManager,
        public $cart = null
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->fetchOrCreate(
            config('cart.auto_create', false)
        );
    }

    /**
     * Returns the total quantities of all items
     *
     * @return int
     */
    public function totalQuantity()
    {
        $cartId = $this->sessionManager->get(
            $this->getSessionKey()
        );

        if (! $cartId) {
            return 0;
        }

        if (is_null(static::$totalItems)) {
            static::$totalItems = CartItem::query()
                ->whereCartId($cartId)
                ->sum('quantity');
        }

        return static::$totalItems;

    }

    /**
     * {@inheritDoc}
     */
    public function forget()
    {
        $this->sessionManager->forget(
            $this->getSessionKey()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function manager()
    {
        if (! $this->cart) {
            $this->fetchOrCreate(create: true);
        }

        return $this->cart->getManager();
    }

    /**
     * {@inheritDoc}
     */
    public function associate(Cart $cart, Authenticatable $user, $policy)
    {
        $this->use(
            $cart->getManager()->associate($user, $policy)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function use(Cart $cart)
    {
        $this->sessionManager->put(
            $this->getSessionKey(),
            $cart->id
        );

        return $this->cart = $cart;
    }

    /**
     * Fetches a cart and optionally creates one if it doesn't exist.
     *
     * @param  bool  $create
     * @return \App\Models\Cart|null
     */
    private function fetchOrCreate($create = false)
    {
        $cartId = $this->sessionManager->get(
            $this->getSessionKey()
        );

        if (! $cartId) {
            return $create ? $this->cart = $this->createNewCart() : null;
        }

        $this->cart = Cart::with(
            config('cart.eager_load', [])
        )->find($cartId);

        if (! $this->cart) {
            if (! $create) {
                return;
            }

            return $this->createNewCart();
        }

        return $this->cart->getManager()->getCart();
    }

    /**
     * {@inheritDoc}
     */
    public function getSessionKey()
    {
        return config('cart.session_key');
    }

    /**
     * Create a new cart instance.
     *
     * @return void
     */
    protected function createNewCart()
    {
        $cart = Cart::create([
            'user_id' => $this->authManager->user()?->id,
        ]);

        return $this->use($cart);
    }

    public function __call($method, $args)
    {
        return $this->manager()->{$method}(...$args);
    }
}
