<?php

namespace App\Http\Livewire\Traits;

use App\Contracts\CartSessionInterface;
use App\Models\Vendor;
use Exception;

trait HasCartMethods
{
    use HasCart;

    /**
     * The editable cart items.
     *
     * @var array
     */
    public array $items = [];

    /**
     * @var array
     */
    public array $vendors = [];

    /**
     * Mount the component
     *
     * @return void
     */
    public function mountHasCartMethods()
    {
        $this->mapItems();
    }

    /**
     * Map the cart item.
     *
     * We want to map out our cart items like this so we can
     * add some validation rules and make them editable.
     *
     * @return void
     */
    protected function mapItems()
    {
        $vendorPackages = $this
            ->cartItems
            ->map(fn ($item) => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'url' => route('products.show', $item->product->slug),
                'quantity' => $item->quantity,
                'title' => $item->product->title,
                'description' => $item->product->description,
                'attributes' => $item->product->attributes,
                'vendor_id' => $item->product->user_id,
                'thumbnail' => $item->product->getThumbnailUrl(),
                'price' => $item->product->price,
                'sub_total' => $item->subTotal,
            ])->groupBy('vendor_id');

        $this->vendors = Vendor::find($vendorPackages->keys())
            ->keyBy('id')
            ->map(function (Vendor $vendor) {
                return [
                    'id' => $vendor->id,
                    'name' => $vendor->vendor_name,
                    'shipping' => ($options = $vendor->getShippingOptions($this->cart->shippingAddress?->latLng)),
                    'info_message' => __(
                        ! $vendor->deliver_products
                            ? 'global.info-message.vendor-only-pickup-available'
                            : (count($options) == 1
                                ? 'global.info-message.vendor-location-unavailable'
                                : ''
                            )
                    ),
                ];
            })->toArray();

        $this->items = $vendorPackages->toArray();
    }

    /**
     * Return the cart meta object.
     *
     * @return \Illuminate\Support\Optional
     */
    public function getCartMetaProperty()
    {
        return cast_meta_object($this->cart);
    }

    /**
     * Return the cart items from the cart.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCartItemsProperty()
    {
        return $this->cart->items ?? collect();
    }

    public function getShippingTotalProperty()
    {
        return $this->cart->getManager()
            ->calculate()
            ->getCart()
            ->shippingTotal;
    }

    public function getSubTotalProperty()
    {
        return $this->cart->getManager()
            ->calculate()
            ->getCart()
            ->subTotal;
    }

    public function getTotalProperty()
    {
        return $this->cart->getManager()
            ->calculate()
            ->getCart()
            ->total;
    }

    /**
     * Update a cart item.
     *
     * @param  int  $id
     * @param  int  $quantity
     * @param  array|null  $meta
     * @return void
     */
    public function updateItem(CartSessionInterface $cartSessionManager, $id, $quantity, $meta = null)
    {
        if ($quantity < 1) {
            return $this->removeItem($cartSessionManager, $id);
            $this->emit('alert-success', trans('product.cart.item-remove'));
        }

        try {
            $cartSessionManager->updateItem($id, $quantity, $meta);

            $this->mapItems();

            $this->emit('cart-updated');

            $this->emit('alert-success', trans('product.cart.qty_updated'));
        } catch (Exception $ex) {
            $this->emit('alert-danger', $ex->getMessage());
        }
    }

    public function removeItem(CartSessionInterface $cartSessionManager, $id)
    {
        $cartSessionManager->removeItem($id);

        if (! $this->cartItems->count()) {
            if (method_exists($this, ($methd = 'handleEmptyCart'))) {
                $this->emit('alert-success', trans('product.cart.item-remove'));

                return $this->{$methd}();
            } else {
                $cartSessionManager->forget();

                $this->emit('cart-cleared');
                $this->emit('alert-success', trans('product.cart.item-remove'));

                to_route('products.index');
            }

            return;
        }

        $this->mapItems();

        $this->emit('removed-from-cart');
    }
}
