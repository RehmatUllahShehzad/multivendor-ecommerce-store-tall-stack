<div>
    <div class="p-4 space-y-4 no-print">
        <div class="flex items-center space-x-4">
            <div class="grid grid-cols-12 w-full space-x-4">
                <div class="col-span-6 md:col-span-6">
                    <x-admin.components.input.text wire:model.debounce.300ms="search" placeholder="{{ __('order.index.search_placeholder') }}" />
                </div>
                <div class="col-span-2 md:col-span-2">
                    <button class="py-2 px-4 text-sm bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 block
                    disabled:cursor-not-allowed disabled:opacity-50
                    border border-transparent
                    rounded-lg shadow-sm
                    inline-flex justify-center font-medium focus:outline-none focus:ring-offset-2 focus:ring-2" onclick="print()">
                        Print
                    </button>
                </div>
                
                <div class="col-span-4 text-right md:col-span-4">
                    <div class="flex items-center space-x-4">
                        <x-admin.components.input.datepicker wire:model="range.from" readonly="readonly" />
                        <span class="text-xs font-medium text-gray-500 uppercase">{{ __('global.to') }}</span>
                        <x-admin.components.input.datepicker wire:model="range.to" readonly="readonly" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-admin.components.table class="w-full whitespace-no-wrap p-2">
        <x-slot name="head">
            <x-admin.components.table.heading>{{ __('ID') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.name') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.amount') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.date') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.status') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading class="no-print"></x-admin.components.table.heading>
        </x-slot>
        <x-slot name="body">
            @forelse($orders as $order)
                <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                    <x-admin.components.table.cell>{{ $order->id }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $order->customer->username }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>
                        {{ $order->total_amount }}
                    </x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $order->created_at->format('m/d/Y') }}
                    </x-admin.components.table.cell>
                    <x-admin.components.table.cell>
                        @if ($order->status->value == 'processing')
                            <span class="px-2 py-1 font-semibold leading-tight text-blue-700 rounded-full dark:text-blue-100">
                                {{ $order->status->value }}
                            </span>
                        @else
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 rounded-full dark:text-green-100">
                                {{ $order->status->value }}
                            </span>
                        @endif
                    </x-admin.components.table.cell>
                    <x-admin.components.table.cell class="no-print">
                        <a  href="{{ route('admin.order.show', $order) }}">{{ __('global.view') }}</a>
                    </x-admin.components.table.cell>
                </x-admin.components.table.row>
            @empty
                <x-admin.components.table.no-results />
            @endforelse
        </x-slot>
    </x-admin.components.table>
    <div class="no-print">
        {{ $orders->links() }}
    </div>
</div>
