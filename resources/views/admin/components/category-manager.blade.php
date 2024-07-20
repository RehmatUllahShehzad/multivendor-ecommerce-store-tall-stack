<div class="shadow sm:rounded-md">
    <div class="flex-col px-4 py-5 space-y-4 bg-white rounded-md sm:p-6">
        <header class="flex items-center justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ __('catalog.categories.heading') }}
            </h3>
            <livewire:admin.catalog.collection-search :existing="$categories" />
        </header>

        <div class="space-y-2">
            @foreach ($this->categories as $index => $category)
                <div wire:key="collection_{{ $index }}">
                    <div class="flex items-center px-4 py-2 text-sm border rounded">
                        @if ($category)
                            <span class="flex-shrink-0 block w-12 mr-4"><img src="{{ $category['thumbnail'] }}" class="rounded shadow w-8 h-8"></span>
                        @endif
                        <div class="flex grow">
                            <div class="grow">
                                {{ $category['name'] }}
                            </div>
                            <div class="flex items-center">
                                <x-admin.components.dropdown.index minimal>
                                    <x-slot name="options">
                                        <x-admin.components.dropdown.link class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 border-b hover:bg-gray-50" :href="route('admin.catalog.category.show', [
                                            'category' => $category['id'],
                                        ])">
                                            {{ __('catalog.categories.view_category') }}
                                        </x-admin.components.dropdown.link>
                                        <x-admin.components.dropdown.button wire:click.prevent="removeCollection({{ $index }})" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 text-red-600 hover:bg-gray-50">
                                            {{ __('global.remove') }}
                                        </x-admin.components.dropdown.button>
                                    </x-slot>
                                </x-admin.components.dropdown.index>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
