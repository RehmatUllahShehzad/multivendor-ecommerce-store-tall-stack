<x-slot name="pageTitle">
    {{ __('catalog.product.index.title') }}
</x-slot>

<div>
    <div class="overflow-hidden shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">
        <div class="p-4 space-y-4">
            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-8">
                        <x-admin.components.input.text wire:model.debounce.300ms="search" placeholder="{{ __('catalog.product.index.search_placeholder') }}" />
                    </div>
                    <div class="col-span-4 text-right md:col-span-4">
                        <div class="sort-item ">
                            <select name="sortBy" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model="sortBy">
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
                <x-admin.components.table.heading>
                    <div class="min-w-[50px]"></div>
                </x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('catalog.product.name') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('catalog.product.slug') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('catalog.product.stock') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('catalog.product.created_at') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.published') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading></x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($products as $product)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>
                            @if ($product->thumbnail)
                                <img class="rounded shadow w-8 h-8" src="{{ $product->getThumbnailUrl() }}" loading="lazy" />
                            @else
                                <x-icon ref="photograph" class="w-8 h-8 mx-auto text-gray-300" />
                            @endif
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $product->title }}</x-admin.components.table.cell>

                        <x-admin.components.table.cell>{{ $product->slug }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $product->available_quantity }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $product->created_at->format('m/d/Y') }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <x-icon :ref="$product->is_published ? 'check' : 'x'" :class="!$product->deleted_at ? 'text-green-500' : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            @if (!$product->deleted_at)
                                <a href="{{ route('admin.catalog.product.show', $product->id) }}" class="text-indigo-500 hover:underline">
                                    {{ __('catalog.product.index.action.edit') }}
                                </a>
                            @endif
                        </x-admin.components.table.cell>
                    </x-admin.components.table.row>
                @empty
                    <x-admin.components.table.no-results />
                @endforelse
            </x-slot>
        </x-admin.components.table>
        <div>
            {{ $products->links() }}
        </div>
    </div>
</div>
