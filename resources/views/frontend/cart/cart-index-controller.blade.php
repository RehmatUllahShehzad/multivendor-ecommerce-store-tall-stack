<div>
    <div class="main-site">
        <div class="inner-section mt-5">
            <div class="main-padding">
                <section>
                    <div class="container">
                        <div class="shopping-cart-header">
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <div class="cart-header-title">
                                        <h2 class="mb-0">Shopping Cart</h2>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="cart-header-button text-end">
                                        <div class="proceed-button-wrap">
                                            <p>Subtotal (<livewire:frontend.cart.counter /> items): $<span>{{ $this->cart->subTotal }}</span>
                                            </p>
                                            <div class="prceed-btn">
                                                <a class="theme-button button" href="{{ route('checkout.shipping') }}">Proceed To Check out</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="container">
                    <section>
                        @foreach ($items as $vendor_id => $vendorPackage)
                            <div class="cart-products-listing-wrap">

                                @foreach ($vendorPackage as $product)
                                    @if ($loop->first)
                                        <div class="carts-listing-title mb-3">
                                            <h4>{{ $vendors[$vendor_id]['name'] }}</h4>
                                        </div>
                                    @endif
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
                                                            <div class="quantity-section d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="selection-box">
                                                                        <input class="border-0" type="button" wire:target="updateItem" wire:click.prevent="updateItem({{ $product['id'] }}, {{ $product['quantity'] - 1 }})" value="-">
                                                                        <input class="border-0 text-center" type="text" name="quantity" value="{{ $product['quantity'] }}" maxlength="2" max="10" size="1" id="number" disabled>
                                                                        <input class="border-0" type="button" wire:click.prevent="updateItem({{ $product['id'] }}, {{ $product['quantity'] + 1 }})" value="+">
                                                                    </div>
                                                                    <div class="remove-item ">
                                                                        <a class="remove-item-btn" wire:click.prevent="removeItem({{ $product['id'] }})" href="javascript:void(0)">Remove Item</a>
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
                                                    <div class="col-lg-2 col-sm-3 product-price-desktop">
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
                </div>
            </div>
        </div>
    </div>
</div>
