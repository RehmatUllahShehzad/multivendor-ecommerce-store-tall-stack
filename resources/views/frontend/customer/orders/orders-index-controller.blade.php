<x-slot name="pageTitle">
    {{ __('customer.orders.index.title') }}
</x-slot>
<x-slot name="pageDescription">
    {{ __('customer.orders.index.title') }}
</x-slot>
<div class="vender-product-management-right">
    <div class="personal-messaging-wrap " id="PersonalMessaging">
        <div class="product-manage-heading product-review-heading">
            <div class="header-select">
                <h3>@lang('customer.orders.index.heading')</h3>
                <div class="form-group">
                    <label for="exampleFormControlSelect6">@lang('vendor.orders.sortby.heading'):</label>
                    <select class="form-control" wire:model="sortBy" id="exampleFormControlSelect6">
                        <option>Sort by</option>
                        <option value="latest">@lang('vendor.orders.sorting.newest')</option>
                        <option value="oldest">@lang('vendor.orders.sorting.oldest')</option>
                        <option value="order_asc">@lang('customer.orders.sorting.ascending')</option>
                        <option value="order_desc">@lang('customer.orders.sorting.descending')</option>
                        <option value="price_asc">@lang('customer.orders.sorting.price.asc')</option>
                        <option value="price_desc">@lang('customer.orders.sorting.price.desc')</option>
                        <option value="status_pro">@lang('customer.orders.sorting.status.processing')</option>
                        <option value="status_com">@lang('customer.orders.sorting.status.completed')</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="payment-history-wrapper">
            <div class="current-balance-table table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="19%">@lang('global.date')</th>
                            <th width="18%">@lang('global.order')#</th>
                            <th width="18%">@lang('global.amount')</th>
                            <th width="34%">@lang('global.status')</th>
                            <th width="11%" class="text-center">@lang('global.details')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->created_at->format('m/d/y') }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>${{ $order->price }}</td>
                                <td>{{ $order->status->name }}</td>
                                <td class="text-center"><a href="{{ route('customer.orders.show', $order->id) }}"><img src="{{ asset('frontend/images/detail.svg') }}" alt="Order Detail"></a>
                                </td>
                            </tr>
                        @empty
                            <div class="product-reviews-wrapper">
                                <div class="product-review-cont">
                                    <div class="product-text">
                                        <h3>@lang('customer.orders.empty')</h3>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center product-pagination">
                {{ $orders->links('frontend.layouts.custom-pagination') }}
            </div>
        </div>
    </div>
    
    @include('frontend.layouts.livewire.loading')

</div>
