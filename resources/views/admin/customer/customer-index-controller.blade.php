<div>
    <div class="p-4 space-y-4">
        <div class="flex items-center space-x-4">
            <div class="grid grid-cols-12 w-full space-x-4">
                <div class="col-span-8 md:col-span-8">
                    <x-admin.components.input.text wire:model.debounce.300ms="search"
                        placeholder="{{ __('customer.index.search_placeholder') }}" />
                </div>
                <div class="col-span-4 text-right md:col-span-4">
                    <div class="sort-item ">
                        <select name="sortBy"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            wire:model="sortBy">
                            <option value="default" selected="selected">{{ __('global.sorting.default') }}</option>
                            <option value="latest">{{ __('global.sorting.latest') }}</option>
                            <option value="oldest">{{ __('global.sorting.oldest') }}</option>
                            <option value="asc">{{ __('global.sorting.ascending') }}</option>
                            <option value="desc">{{ __('global.sorting.descending') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-admin.components.table class="w-full whitespace-no-wrap p-2">
        <x-slot name="head">
            <x-admin.components.table.heading>{{ __('global.firstname') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.lastname') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.name') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.email') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.type') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.date') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.active') }}</x-admin.components.table.heading>
        </x-slot>
        <x-slot name="body">
            @forelse($customers as $customer)
                <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                    <x-admin.components.table.cell>{{ $customer->first_name }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $customer->last_name }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $customer->username }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $customer->email }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                            {{ $customer->isVendor() ? 'Vendor' : 'Customer' }}
                        </span>
                    </x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $customer->created_at->format('m/d/Y') }}
                    </x-admin.components.table.cell>
                    <x-admin.components.table.cell>
                        <a href="{{ route('admin.customer.show', $customer->id) }}"
                            class="text-indigo-500 hover:underline">
                            {{ __('customer.index.action.edit') }}
                        </a>
                    </x-admin.components.table.cell>
                </x-admin.components.table.row>
            @empty
                <x-admin.components.table.no-results />
            @endforelse
        </x-slot>
    </x-admin.components.table>
    <div>
        {{ $customers->links() }}
    </div>
</div>
