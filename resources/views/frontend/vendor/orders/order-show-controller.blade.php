<x-slot name="pageTitle">
    {{ __('vendor.order.show.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('vendor.order.show.title') }}
</x-slot>
<div class="vender-product-management-right">
    <div class="my-order-detail " id="getOrderDetail">
        <div class="product-manage-heading product-review-heading">
            <div class="header-select">
                <h3>
                    @lang('vendor.order.detail.title')
                    <span>
                        ({{ $this->order->order->order_number }})
                    </span>
                </h3>
                <p>
                    @lang('vendor.order.tracking_number') {{ $this->order->tracking_number ?? 'N/A' }}
                </p>
            </div>
        </div>
        <div class="order-detail-content vendor-orders-detail">
            <div class="order-detail-heading">
                <div class="order-detail-left">
                    <img src="/frontend/images/location-icon.svg" alt="location Icon">
                    <h5>
                        {{ $this->order->order->customer->name }}
                        <span>
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
                        </span>
                    </h5>
                </div>
                @if ($this->order->conversation)
                    <a href="{{ route('vendor.message.show', $this->order) }}" class="order-detail-right" data-bs-toggle="tooltip" data-placement="bottom" title="Messages">
                    </a>
                @endif
            </div>
            @foreach ($this->order->items as $orderDetail)
                <div class="orders-detail">
                    <div class="orders-wrapper">
                        <a href="{{ route('products.show', $orderDetail->product->slug) }}" class="order-product-pic" style="background-image: url('{{ $orderDetail->product->thumbnail?->getUrl() }}')"></a>
                        <div class="order-product-name">
                            <h3>{{ $orderDetail->product->title }}</h3>
                        </div>
                        <div class="order-product-weight">
                            <p>
                                {{ $orderDetail->quantity }}
                                {{ $orderDetail->product->unit?->name }}
                            </p>
                        </div>
                        <div class="order-product-price">
                            <p>
                                ${{ $orderDetail->product->price }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="orders-tracking-bill">
                <div class="orders-tracking">
                    <form action="#">
                        <div class="order-status">
                            <div class="order-status-select">
                                <div class="form-group">
                                    <select class="form-control" @if ($this->order->isCompleted()) disabled @endif wire:model="status" id="exampleFormControlSelect7">
                                        <option selected>
                                            @if ($this->order->isCompleted())
                                                {{ $this->order->status->value }}
                                            @else
                                                @lang('global.status')
                                            @endif
                                        </option>
                                        @foreach ($this->getOrderStatuses() as $orderStatus)
                                            <option value="{{ $orderStatus->value }}">{{ $orderStatus->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <a @if (!$this->order->isCompleted()) wire:click.prevent="update({{ $this->order->id }})" 
                                    href="#" 
                                @else 
                                    disabled style="cursor: not-allowed;" @endif class="order-status-btn">@lang('vendor.orders.update.btn')
                            </a>
                            @error('status')
                                <div class="get-form-error mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="order-status">
                            <div class="order-status-select order-status-input">
                                <div class="form-group">
                                    <input type="text" wire:model.defer="tracking_number" class="form-control" id="exampleFormControlSelect8" aria-labelledby="exampleFormControlSelect8" placeholder="Tracking#">
                                </div>

                            </div>
                            <a href="#" wire:click.prevent="submit({{ $this->order->id }})" class="order-status-btn">@lang('global.submit')</a>
                        </div>
                        @error('tracking_number')
                            <div class="get-form-error mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </form>
                </div>
                <div class="orders-bill">
                    <h5>@lang('global.sub_total'):</h5>
                    <p>${{ $order->sub_total }}</p>
                    <h5>@lang('customer.orders.delivery.charges'):</h5>
                    <p>${{ $order->shipping_fee }}</p>
                    <h5>@lang('customer.orders.service.fee'):</h5>
                    <p>- ${{ $order->service_fee }}</p>
                    <div class="total-bill">
                        <h5>@lang('global.total')</h5>
                        <h6>${{ $order->vendorTotal() }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.layouts.livewire.loading')
</div>
