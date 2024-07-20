<x-slot name="currentStep">
    {{ $currentStep }}
</x-slot>
<x-slot name="title">
    Place Order
</x-slot>
<div class="container">
    {{-- {{dd($errors)}} --}}
    <div class="review-cart-main mx-auto">
        <section>
            <div class="review-cart-wrap">
                <div class="review-title">
                    <h2>Review Your Order</h2>
                </div>
                <div class="cart-short-details">
                    <div class="row">
                        @foreach ($this->cart->addresses as $address)
                            <div class="col-lg-3 col-md-4">
                                <div class="review-item">
                                    <h4><b>{{ ucfirst($address->type) }} Address</b><span><a
                                                href="{{ $address->type == 'shipping' ? route('checkout.shipping') : route('checkout.billing') }}">Change</a></span>
                                    </h4>
                                    <p>{{ $address->address_1 }}, {{ $address->address_2 }}, {{ $address->city }},
                                        {{ $address->zip }}, {{ $address->state->name }}, {{ $address->country->name }}
                                    </p>
                                    <p>Phone: {{ $address->phone }}</p>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-lg-1 d-lg-block d-none"></div>
                        <div class="col-lg-5 col-md-4">
                            <div class="review-item">
                                <h4><b>Payment method </b><span><a
                                            href="{{ route('checkout.payment') }}">Change</a></span></h4>
                                <p> <img src="{{ asset('frontend/images/american-card-logo.png') }}"
                                        alt="">{{ getFormattedCardNumber($this->cart->meta->payment_card_number) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            @foreach ($items as $vendor_id => $vendorItems)
                <div class="cart-products-listing-wrap">
                    <div class="carts-listing-title mb-3">
                        <div class="carts-listing-title mb-3">
                            <h4>{{ $vendors[$vendor_id]['name'] }}</h4>
                            <div style="font-size:small; margin-top:4px; font-weight: bold; color:#3a589e">
                                @if ($vendors[$vendor_id]['info_message'])
                                    &nbsp;&nbsp; ({{ $vendors[$vendor_id]['info_message'] }})
                                @endif
                            </div>
                        </div>


                        <div wire:loading.class="d-none">
                            <select class="number-font" name="delivery-options"
                                wire:model="selectedShippingOptions.{{ $vendor_id }}.selected">
                                <option value="" selected>Choose a delivery option</option>

                                @foreach ($vendors[$vendor_id]['shipping'] as $shippingOption)
                                    <option class="number-font" value="{{ $shippingOption['type'] }}">
                                        {{ $shippingOption['name'] }} ${{ $shippingOption['value'] }}</option>
                                @endforeach
                            </select>
                            @error("shipping.{$vendor_id}.required")
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <x-button-loading wire:loading />
                    </div>
                    @foreach ($vendorItems as $product)
                        <div class="cart-products-listing">
                            <div class="cart-product">
                                <div class="row">
                                    <div class="cart-product-img-box">
                                        <div class="cart-product-img">
                                            <img src="{{ $product['thumbnail'] }}" alt="">
                                        </div>
                                    </div>
                                    <div class="row cart-product-info">
                                        <div class="col-xl-10 col-md-9">
                                            <div class="cart-product-info-wrap">
                                                <div class="product-info">
                                                    <h4>{!! $product['title'] !!}</h4>
                                                    <p>{!! $product['description'] !!}</p>
                                                </div>
                                                <div
                                                    class="quantity-section d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="selection-box">
                                                            <input class="border-0" type="button" value="-"
                                                                wire:target="updateItem"
                                                                wire:click.prevent="updateItem({{ $product['id'] }}, {{ $product['quantity'] - 1 }})">
                                                            <input class="border-0 text-center" id="number"
                                                                name="quantity" type="text"
                                                                value="{{ $product['quantity'] }}" maxlength="2"
                                                                max="10" size="1" disabled>
                                                            <input class="border-0" type="button" value="+"
                                                                wire:click.prevent="updateItem({{ $product['id'] }}, {{ $product['quantity'] + 1 }})">
                                                        </div>
                                                        <div class="remove-item ">
                                                            <a class="remove-item-btn" href="javascript:void(0)"
                                                                wire:click.prevent="removeItem({{ $product['id'] }})">Remove
                                                                Item</a>
                                                        </div>
                                                    </div>
                                                    <div class="mobile-product-price">
                                                        <div class="product-price text-end">
                                                            <h4>${{ $product['price'] }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-3 product-price-desktop">
                                            <div class="product-price text-end">
                                                <h4>${{ $product['price'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endforeach
        </section>
        <form wire:submit.prevent="submit">
            <section>
                <div class="order-summary-wrap mt-2">
                    <div class="order-summary-inner ms-auto mt-4">
                        <p>
                            <b>Order Summary</b>
                        </p>
                        <div class="summary-table">
                            <table style="width:100%">
                                <tbody>
                                    <tr>
                                        <th>Items (
                                            <livewire:frontend.cart.counter />):
                                        </th>
                                        <td>$<span>{{ $this->subTotal }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Shipping & handling</th>
                                        <td>$<span>{{ $this->shippingTotal }}</span></td>
                                    </tr>
                                    <div class="total">
                                        <tr>
                                            <th> <b> Order Total:</b></th>
                                            <td><b>$<span>{{ $this->total }}</span></b></td>
                                        </tr>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                        <div class="place-order-btn mt-4 text-end">
                            <button class="theme-button" type="submit" wire:loading.class="d-none">Place Order</button>
                            <x-button-loading wire:loading wire:target="submit" />
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>
