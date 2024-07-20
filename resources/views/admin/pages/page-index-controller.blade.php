<x-slot name="pageTitle">
    {{ __('cms.page.index.title') }}
</x-slot>
<div>
    <div
        class="overflow-hidden shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">
        <div class="text-right mb-4 p-4">
            <x-admin.components.button href="{{ route('admin.pages.create') }}" tag="a">
                {{ __('Create Page') }}
            </x-admin.components.button>
        </div>

        <div class="p-4 space-y-4">
            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-8">
                        <x-admin.components.input.text wire:model.debounce.300ms="search"
                            placeholder="{{ __('Search') }}" />
                    </div>
                    <div class="col-span-4 text-right md:col-span-4">
                        <x-admin.components.input.checkbox-button wire:model="showTrashed" :value="true"
                            autocomplete="off">
                            {{ __('Show All') }}
                        </x-admin.components.input.checkbox-button>
                    </div>
                </div>
            </div>
        </div>
        <x-admin.components.table class="w-full whitespace-no-wrap p-2">
            <x-slot name="head">
                <x-admin.components.table.heading>{{ __('Name') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('Slug') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('Active') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('Created') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading></x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($pages as $page)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>{{ $page->title }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $page->slug }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <x-icon :ref="!$page->deleted_at ? 'check' : 'x'" :class="!$page->deleted_at ? 'text-green-500' : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $page->created_at->format('m/d/Y') }}
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <div class="flex flex-row justify-between">
                                @if (!$page->deleted_at)
                                    <a class="text-indigo-500 hover:underline"
                                        href="{{ route('admin.pages.show', $page->id) }}">
                                        {{ __('Edit') }}
                                    </a>
                                |
                                <a class="text-indigo-500 hover:underline"
                                    href="{{ route('admin.editor.index', $page) }}" target="_blank">
                                    {{ __('Editor') }}
                                </a>
                                @endif
                            </div>
                        </x-admin.components.table.cell>
                    </x-admin.components.table.row>
                @empty
                    <x-admin.components.table.no-results />
                @endforelse
            </x-slot>
            </x-table>
            <div>
                {{ $pages->links() }}
            </div>
    </div>
</div>
