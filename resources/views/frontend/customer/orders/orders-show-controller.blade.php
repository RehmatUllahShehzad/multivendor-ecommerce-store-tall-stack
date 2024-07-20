<x-slot name="pageTitle">
    {{ __('customer.orders.show.detail.heading') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('customer.orders.show.detail.heading') }}
</x-slot>
<div class="vender-product-management-right" x-data="{
    reviewData: {
        id: null,
        rating: @entangle('ratingValue').defer,
        comment: @entangle('comment').defer,
    },

    openRatingModal(id) {
        this.show = true;
        this.reviewData.id = id;
        this.reviewData.rating = null;
        this.$dispatch('open-modal');
    }
}">
    <div class="my-order-detail " id="getOrderDetail">
        <div class="product-manage-heading product-review-heading">
            <div class="header-select">
                <h3>@lang('customer.orders.show.detail.heading')</h3>
                <div class="header-right">
                    <p class="header-content">
                        <span>@lang('customer.orders.number')</span> <br />
                        <span>{{ $this->order->order_number }}</span>
                    </p>
                    <p class="header-content">
                        <span>@lang('customer.payment_methods.card.name.label')</span> <br />
                        <span>{{ $this->lastTransaction->name_on_card }}</span>
                    </p>
                    <p class="header-content">
                        <span>@lang('customer.payment_methods.card.number.label')</span> <br />
                        <span>{{ getFormattedCardNumber($this->Card->last_four) }}</span>
                    </p>
                    <p class="header-content">
                        <span>@lang('customer.payment_methods.card.expiry.label')</span> <br />
                        <span>{{ $this->lastTransaction->expiry_month }} -
                            {{ $this->lastTransaction->expiry_year }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="order-detail-content customer-order-detail">
            @foreach ($this->order->packages as $orderPackage)
                <div class="orders-detail">
                    <div class="orders-detail-heading">
                        <h3>{{ $orderPackage->vendor->vendor_name }}</h3>
                        <a href="{{ route('customer.message.show', $orderPackage) }}">@lang('customer.orders.contact.vendor.heading')</a>
                    </div>
                    @foreach ($orderPackage->items as $packageItem)
                        <div class="orders-wrapper">
                            <a class="order-product-pic" href="{{ route('products.index') }}"
                                style="background-image: url({{ $packageItem->product->getThumbnailUrl() }})"></a>
                            <div class="order-product-name">
                                <h3>{{ $packageItem->product->title }}</h3>

                                @if ($order->isCompleted() && !$order->hasReviewFor($packageItem->product))
                                    <button type="button" class="review-btn"
                                        @click="openRatingModal({{ $packageItem->product->id }})"
                                        wire:key="product_{{ $packageItem->product->id }}">
                                        @lang('customer.orders.add.review.btn')
                                    </button>
                                @endif
                            </div>
                            <div class="order-product-weight">
                                <p>
                                    {{ $packageItem->quantity }}
                                    {{ $packageItem->product->unit?->name }}
                                </p>
                            </div>
                            <div class="order-product-price">
                                <p>
                                    ${{ $packageItem->product->price }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <div class="orders-last-wrapper">
                        <div class="order-product-text">
                            @if ($orderPackage->type == 'pickup')
                                <p>
                                    @lang('customer.orders.pickup.detail') {{ $orderPackage->vendor->company_address }}
                                </p>
                            @else
                                <p>
                                    @lang('customer.orders.delivery.detail')
                                    @if ($value = $this->shippingAddress->address_1 ?? '')
                                        {{ $value }},
                                    @endif
                                    @if ($value = $this->shippingAddress->address_2 ?? '')
                                        {{ $value }},
                                    @endif
                                    @if ($value = $this->shippingAddress->city ?? '')
                                        {{ $value }},
                                    @endif
                                    @if ($value = $this->shippingAddress->state->name ?? '')
                                        {{ $value }}
                                    @endif
                                    @if ($value = $this->shippingAddress->zip ?? '')
                                        {{ $value }},
                                    @endif
                                    @if ($value = $this->shippingAddress->country->name ?? '')
                                        {{ $value }}
                                    @endif
                                </p>
                            @endif
                        </div>
                        <div class="order-product-charges">
                            <p>
                                <span>@lang('customer.orders.delivery.charges'): </span>${{ $orderPackage->shipping_fee }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="orders-tracking-bill pe-0">
                <div class="orders-bill">
                    <h5>@lang('global.sub_total'):</h5>
                    <p>${{ $order->subtotal }}</p>
                    <h5>@lang('customer.orders.delivery.charges'):</h5>
                    <p>${{ $order->shipping_fee }}</p>
                    <div class="total-bill">
                        <h5>@lang('global.total')</h5>
                        <h6>${{ $order->price }}</h6>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('frontend.layouts.livewire.loading')

    <x-modal.dialog form="$wire.rate(reviewData.id, reviewData.orderId)">
        <x-slot name="title">
            <h3>@lang('customer.orders.add.review.title')</h3>
            <p>@lang('customer.orders.review.validation.message')</p>
        </x-slot>
        <x-slot name="content">
            <div>
                <p>
                    <span class="me-3">
                        <template x-for="number in [0, 1, 2, 3, 4]">
                            <i class="fas fa-star stars" :class="{ 'star-active': reviewData.rating > number }"
                                @click="reviewData.rating = number + 1"></i>
                        </template>
                    </span>
                    @lang('customer.orders.rating.title')
                </p>
                @error('ratingValue')
                    <div class="get-form-error">
                        <div class="get-form-error">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
            <div class="mt-2 col-md-12">
                <div class="mb-4">
                    <div class="pt-1 mb-0 get-form">
                        <textarea class="form-control" id="floatingPassword" rows="8" x-model="reviewData.comment"
                            placeholder="@lang('customer.orders.review.title')"></textarea>
                    </div>
                </div>
                @error('comment')
                    <div class="get-form-error">
                        <div class="get-form-error">
                            {{ $message }}
                        </div>
                    </div>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="new-near-you-button vice-versa" type="button" @click="$dispatch('close')">
                @lang('global.cancel')
            </button>
            <button class="new-near-you-button" type="submit">
                @lang('global.submit')
                <x-button-loading wire:loading />
            </button>
        </x-slot>
    </x-modal.dialog>
</div>
