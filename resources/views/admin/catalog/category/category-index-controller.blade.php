<x-slot name="pageTitle">
    {{ __('catalog.categories.index.title') }}
</x-slot>
<div>
    <div class="text-right mb-4">
        <x-admin.components.button tag="a" href="{{ route('admin.catalog.category.create') }}">
            {{ __('catalog.categories.create.title') }}
        </x-admin.components.button>
    </div>

    <div class="shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">

        <div class="p-4 space-y-4">

            <livewire:admin.catalog.category.category-tree
                :nodes='$tree'
                sortGroup='root'
                key='tree_root' />

            @empty($tree)
                <div class="flex-col p-12 space-y-4 text-sm text-center bg-white dark:bg-gray-800">
                    <x-admin.components.no-results />
                </div>
            @endempty
        </div>
    </div>
</div>
