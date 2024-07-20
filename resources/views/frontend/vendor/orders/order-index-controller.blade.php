<x-slot name="pageTitle">
    {{ __('vendor.order.index.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('vendor.order.index.title') }}
</x-slot>
<div class="vender-product-management-right">
    <div class="my-order-container" id="getOrder">
        <form method="get">
            <div class="product-manage-heading product-review-heading search-setting">
                <div class="header-select">
                    <h3>@lang('vendor.order.index.heading')</h3>
                    <div class="form-group">
                        <label for="exampleFormControlSelect6">@lang('vendor.orders.sortby.heading'):</label>
                        <select class="form-control" wire:model="sortBy" id="exampleFormControlSelect6">
                            <option>Sort by</option>
                            <option value="latest">@lang('vendor.orders.sorting.newest')</option>
                            <option value="oldest">@lang('vendor.orders.sorting.oldest')</option>
                            <option value="asc">@lang('vendor.orders.sorting.ascending')</option>
                            <option value="desc">@lang('vendor.orders.sorting.descending')</option>
                            <option value="a_to_z">@lang('vendor.orders.sorting.name.asc')</option>
                            <option value="z_to_a">@lang('vendor.orders.sorting.name.desc')</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="search-wrap">
                <div class="search-in">
                    <div class="input-group">
                        <input type="text" class="form-control" wire:model.defer="search" placeholder="Name, Order Number, Order Id" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>
                </div>
                <div class="search-inner">
                    <div class="form-group">
                        <x-lightpick wire:model.defer="dateRange" />
                    </div>
                </div>
                <button class="btn btn-outline-secondary" type="button" wire:click="$refresh">
                    <span>
                        <svg style="display: inline-block;" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path style="stroke: none"
                                d="M22.6159 20.8099L16.8201 15.0141C19.6021 11.3482 19.3237 6.08522 15.9802 2.7417C14.2125 0.973758 11.8616 0 9.36105 0C6.8605 0 4.50963 0.973758 2.7417 2.7417C0.973758 4.50963 0 6.8605 0 9.36105C0 11.8613 0.973758 14.2122 2.7417 15.9802C4.5666 17.8053 6.9637 18.7178 9.36105 18.7178C11.3556 18.7178 13.3491 18.0837 15.0141 16.8201L20.8099 22.6159C21.0589 22.8654 21.3861 22.9901 21.7129 22.9901C22.0396 22.9901 22.3668 22.8654 22.6159 22.6159C23.1147 22.1172 23.1147 21.3085 22.6159 20.8099ZM4.5482 14.1742C3.26229 12.8885 2.55445 11.1793 2.55445 9.36105C2.55445 7.54279 3.26229 5.83361 4.5482 4.54795C5.83361 3.26229 7.54305 2.55445 9.36105 2.55445C11.1791 2.55445 12.8885 3.26229 14.1742 4.5482C16.828 7.20203 16.828 11.5203 14.1742 14.1744C11.5201 16.8282 7.20177 16.8277 4.5482 14.1742Z"
                                fill="#fff"></path>
                        </svg>
                    </span>
                </button>
                <button class="btn btn-outline-secondary" type="button" wire:click="resetFields">@lang('global.clear')</button>
            </div>
        </form>
        @forelse ($orders as $order)
            <a href="{{ route('vendor.orders.show', $order->id) }}" class="product-manage-order">
                <div class="order-summery">
                    <h3>
                        {{ $order->order->customer->name }} <span>({{ $order->order->order_number }})</span>
                    </h3>
                    <p>${{ $order->sub_total }}</p>
                    <p>{{ $order->created_at->format('m/d/y') }}</p>
                </div>
                @if ($order->status->value == 'processing')
                    <div class="status-view processing">
                        {{ $order->status->value }}
                    </div>
                @elseif($order->status->value == 'completed')
                    <div class="status-view complete">
                        {{ $order->status->value }}
                    </div>
                @else
                    <div class="status-view shipped">
                        {{ $order->status->value }}
                    </div>
                @endif
            </a>
        @empty
            <p>@lang('vendor.order.empty')</p>
        @endforelse
        <div class="text-center product-pagination">
            {{ $orders->links('frontend.layouts.custom-pagination') }}
        </div>
    </div>

</div>
