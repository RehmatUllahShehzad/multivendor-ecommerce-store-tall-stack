<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart\Actions\CalculateShippingTotal;
use App\Services\Cart\Actions\CreateOrder;
use App\Services\Cart\Actions\MergeCart;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CartManager
{
    /**
     * Initialize the cart manager.
     *
     * @param  Cart  $cart
     */
    public function __construct(
        protected Cart $cart,
    ) {
        //
    }

    /**
     * Calculate the cart totals.
     *
     * @return self
     */
    public function calculate()
    {
        $subTotal = $this->calculateItems()->sum('subTotal');

        $shippingTotal = app(CalculateShippingTotal::class)->execute($this->cart);

        $this->cart->shippingTotal = $shippingTotal;

        $this->cart->subTotal = $subTotal;

        $this->cart->total = $subTotal + $shippingTotal;

        return $this;
    }

    /**
     * Return the cart model instance.
     *
     * @return \App\Models\Cart
     */
    public function getCart(): Cart
    {
        if (is_null($this->cart->total)) {
            $this->calculate();
        }

        return $this->cart;
    }

    /**
     * Add a item to the cart.
     *
     * @param  Product  $product
     * @param  int  $quantity
     * @param  array  $meta
     * @return bool
     */
    public function add(Product $product, int $quantity = 1, $meta = [])
    {
        if (! $product->canBuyQuantity($quantity)) {
            throw new Exception(
                __('exceptions.cart_item_quantity_exceed')
            );
        }

        if ($quantity < 1) {
            throw new Exception(
                __('exceptions.invalid_cart_item_quantity', [
                    'quantity' => $quantity,
                ])
            );
        }

        if ($quantity > 1000000) {
            throw new Exception();
        }

        // Do we already have this item?
        $existing = $this->cart->load('items')->items->first(function ($item) use ($product, $meta) {
            return $item->product_id == $product->id &&
                array_diff((array) ($item->meta ?? []), $meta ?? []) == [] &&
                array_diff($meta ?? [], (array) ($item->meta ?? [])) == [];
        });

        if ($existing) {
            if (! $product->canBuyQuantity($existing->quantity + $quantity)) {
                throw new Exception(
                    __('exceptions.cart_item_quantity_exceed')
                );
            }

            $existing->update([
                'quantity' => $existing->quantity + $quantity,
            ]);

            return true;
        }

        $this->cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'meta' => $meta,
        ]);

        return true;
    }

    /**
     * Add cart items.
     *
     * @param  iterable  $items
     * @return bool
     */
    public function addItems(iterable $items)
    {
        collect($items)->each(function ($item) {
            $this->add(
                $item['product_id'],
                $item['quantity'],
                $item['meta'] ?? null
            );
        });

        return true;
    }

    /**
     * Remove a cart item from the cart.
     *
     * @param  int|string  $cartItemId
     * @return \App\Models\Cart
     *
     * @throws Exception
     */
    public function removeItem($cartItemId)
    {
        try {
            // If we're trying to remove a item that does not
            // belong to this cart, throw an exception.
            $item = $this->cart->items()->whereId($cartItemId)->first();

            if (! $item) {
                throw new Exception(
                    __('exceptions.cart_item_id_mismatch')
                );
            }

            $item->delete();

            return $this->calculate()->getCart();
        } catch (Exception $ex) {
            return session()->flash('alert-danger', $ex->getMessage());
        }
    }

    /**
     * Deletes all cart items.
     */
    public function clear()
    {
        $this->cart->items()->delete();

        return $this->calculate()->getCart();
    }

    /**
     * Update cart items.
     *
     * @param  Collection  $items
     * @return \App\Models\Cart
     */
    public function updateItems(Collection $items)
    {
        DB::transaction(function () use ($items) {
            $items->each(function ($item) {
                $this->updateItem(
                    $item['id'],
                    $item['quantity'],
                    $item['meta'] ?? null
                );
            });
        });

        return $this->calculate()->getCart();
    }

    /**
     * Update a cart item.
     *
     * @param  string|int  $id
     * @param  int  $quantity
     * @param  array|null  $meta
     * @return void
     */
    public function updateItem($id, int $quantity, $meta = null)
    {
        if ($quantity < 1) {
            throw new Exception(
                __('exceptions.invalid_cart_item_quantity', [
                    'quantity' => $quantity,
                ])
            );
        }

        if ($quantity > 1000000) {
            throw new Exception();
        }

        $existing = CartItem::whereId($id)->first();

        if (! $existing->product->canBuyQuantity($quantity)) {
            throw new Exception(
                trans('exceptions.cart_item_quantity_exceed')
            );
        }

        CartItem::whereId($id)->update([
            'quantity' => $quantity,
            'meta' => $meta,
        ]);
    }

    /**
     * Calculate the cart items.
     *
     * @return Collection
     */
    private function calculateItems(): Collection
    {
        return $this->cart->items->map(function ($item) {

            $item->subTotal = $item->product->price * $item->quantity;

            return $item;
        });
    }

    /**
     * Associate a user to the cart.
     *
     * @param  User  $user
     * @param  string  $policy
     * @return \App\Models\Cart
     */
    public function associate(User $user, $policy = 'merge')
    {
        if ($policy == 'merge') {
            $userCart = Cart::query()->whereUserId($user->getKey())
                ->unMerged()
                ->latest()
                ->active()
                ->first();

            if ($userCart) {
                $this->cart = app(MergeCart::class)->execute($userCart, $this->cart);
            }
        }

        if ($policy == 'override') {
            $userCart = Cart::query()->whereUserId($user->getKey())
                ->unMerged()
                ->latest()
                ->active()
                ->first();

            if ($userCart && $userCart->id != $this->cart->id) {
                $userCart->update([
                    'merged_id' => $userCart->id,
                ]);
            }
        }

        $this->cart->update([
            'user_id' => $user->getKey(),
        ]);

        return $this->cart;
    }

    public function createOrder()
    {
        $this->calculate();

        return app(CreateOrder::class)->execute($this->cart);
    }
}
