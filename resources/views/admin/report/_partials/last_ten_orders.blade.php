<div class="overflow-hidden shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg mt-5">
    <div class="p-4 space-y-4">
        <div class="flex items-center space-x-4">
            <div class="grid grid-cols-12 w-full space-x-4">
                <div class="col-span-8 md:col-span-8">
                    {{ __('reports.last_ten_orders') }}
                </div>
            </div>
        </div>
    </div>
    <x-admin.components.table class="w-half whitespace-no-wrap p-2">
        <x-slot name="head">
            <x-admin.components.table.heading>{{ __('reports.last_ten_orders.order_id') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('reports.last_ten_orders.customer_name') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('reports.last_ten_orders.price') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('reports.last_ten_orders.date') }}</x-admin.components.table.heading>
        </x-slot>
        <x-slot name="body">
            @forelse($lastTenOrders as $order)
                <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                    <x-admin.components.table.cell>{{ $order->id }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $order->customer->name ?? '' }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>${{ number_format($order->total_amount, 2) }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $order->created_at->format('d/m/Y') }}</x-admin.components.table.cell>
                </x-admin.components.table.row>
            @empty
                <x-admin.components.table.no-results />
            @endforelse
        </x-slot>
    </x-admin.components.table>
</div>