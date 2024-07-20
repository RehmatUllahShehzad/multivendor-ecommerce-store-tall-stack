<div class="buttons-of-new-near-you">
    <div class="new-near-you-counter" x-data="{
        quantity: @entangle('quantity').defer,
        addQty() {
            this.quantity += 1;
        },
        rmQty() {
            if (this.quantity <= 1) {
                return;
            }
    
            this.quantity -= 1;
        }
    }">
        <input class="minus" type="button" value="-" wire:target="updateQuantity" @click="rmQty()">
        <input class="counter" id="number" type="text" x-model="quantity" disabled>
        <input class="plus" type="button" value="+" wire:target="updateQuantity" @click="addQty()">
    </div>
    <button class="{{ $addSearchClass ? 'are-you-button' : 'new-near-you-button'}}" wire:click.prevent="addToCart()" target="addToCart">
        Add to Cart
        <x-button-loading wire:loading wire:target="addToCart" />

    </button>

    @if ($showViewCart)
        <a href="{{ route('checkout.cart') }}" class="new-near-you-button vice-versa">
            {{ trans('product.view-cart-button') }}
        </a>
    @endif
</div>
