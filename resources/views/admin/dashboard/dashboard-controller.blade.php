<div>
    {{-- forms --}}
    <div class="py-4 space-y-4">
        <div class="flex items-center space-x-4">
            <div class="grid grid-cols-12 w-full space-x-4">
                <div class="col-span-8 md:col-span-8 text-2xl font-semibold text-gray-900">
                    {{ __('dashboard.dashboard') }}
                </div>
            </div>
        </div>
    </div>

    {{-- cards --}}
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <x-admin.components.stat-card value="{{ $totalUsers }}" icon="user-group" icon-class="flex items-center justify-center" label="{{ __('dashboard.cards.total_users') }}" />
        <x-admin.components.stat-card value="${{ $totalSales }} / ${{ $totalPayables }}" icon="currency-dollar" icon-class="flex items-center justify-center" label="{{ __('dashboard.cards.total_sales') }} / {{ __('dashboard.cards.total_payables') }}" />
        <a href="{{ route('admin.catalog.product.index') }}">
            <x-admin.components.stat-card value="{{ $totalProducts }}" icon="heart" icon-class="flex items-center justify-center" label="{{ __('dashboard.cards.total_products') }}" />
        </a>
        <a href="{{ route('admin.order.index') }}">
            <x-admin.components.stat-card value="{{ $totalOrders }}" icon="template" icon-class="flex items-center justify-center" label="{{ __('dashboard.cards.total_orders') }}" />
        </a>
    </div>

    {{-- graph --}}
    <livewire:admin.dashboard.sales-performance />

    {{-- recent orders and top selling products --}}
    <div class="py-4 mt-8">
        <div class="flex flex-row gap-x-8">
            <div class="basis-2/3">
                <div class="p-8 bg-white rounded-lg h-96">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('dashboard.recent_orders') }}</h3>
                    <table class="w-full mt-8 table-auto font-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="pb-2 text-sm font-normal text-left">{{ __('dashboard.order_ref') }}</th>
                                <th class="pb-2 text-sm font-normal text-center">{{ __('dashboard.customer') }}</th>
                                <th class="pb-2 text-sm font-normal text-center">{{ __('dashboard.no_items') }}</th>
                                <th class="pb-2 text-sm font-normal text-center">{{ __('dashboard.placed_at') }}</th>
                                <th class="pb-2 text-sm font-normal text-right">{{ __('dashboard.total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td class="pt-4 text-sm">
                                        <a class="underline-offset-2 hover:decoration-blue-500 hover:underline hover:decoration-dashed" href="{{ route('admin.order.show', $order) }}">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="pt-4 text-sm text-center">{{ $order->customer->name }}</td>
                                    <td class="pt-4 text-sm text-center">{{ $order->packages->count() }}</td>
                                    <td class="pt-4 text-sm text-center">
                                        {{ optional($order->created_at)->format('jS F Y h:ma') }}</td>
                                    <td class="pt-4 text-sm text-right">${{ $order->total_amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="basis-1/3">
                <div class="p-8 bg-white rounded-lg h-96">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('dashboard.top_selling_products') }}</h3>

                    @foreach ($topSellingProducts as $product)
                        <div class="relative flex items-center py-8 space-x-3 bg-white border-b border-slate-100">
                            <div class="flex-shrink-0">
                                <img class="w-24 h-24 rounded-lg" src="{{ $product->getThumbnailUrl() }}" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <a class="focus:outline-none" target="_blank" href="{{ route('products.show',$product) }}">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $product->title }}
                                        <span class="block text-sm">${{ $product->total_price }}</span>
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ $product->total_sale }} orders
                                    </p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
