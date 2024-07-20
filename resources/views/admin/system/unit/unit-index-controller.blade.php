<x-slot name="pageTitle">
    {{ __('units.index.title') }}
</x-slot>

<div>
    <div class="text-right mb-4">
        <x-admin.components.button tag="a" href="{{ route('admin.system.unit.create') }}">
            {{ __('units.index.action.create') }}
        </x-admin.components.button>
    </div>

    <div class="overflow-hidden shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">

        <div class="p-4 space-y-4">

            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-8">
                        <x-admin.components.input.text wire:model.debounce.300ms="search" placeholder="{{ __('units.index.search_placeholder') }}" />
                    </div>
                    <div class="col-span-4 text-right md:col-span-4">
                        <x-admin.components.input.checkbox-button wire:model="showTrashed" autocomplete="off">
                            {{ __('units.show_deleted') }}
                        </x-admin.components.input.checkbox-button>
                    </div>
                </div>
            </div>
        </div>

        <x-admin.components.table class="w-full whitespace-no-wrap p-2">
            <x-slot name="head">
                <x-admin.components.table.heading>{{ __('units.name') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.date') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.active') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading></x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($units as $unit)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>{{ $unit->name }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $unit->created_at->format('m/d/Y') }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <x-icon :ref="!$unit->deleted_at ? 'check' : 'x'" :class="!$unit->deleted_at ? 'text-green-500' : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            @if (!$unit->deleted_at)
                                <a href="{{ route('admin.system.unit.show', $unit->id) }}" class="text-indigo-500 hover:underline">
                                    {{ __('units.index.action.edit') }}
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
            {{ $units->links() }}
        </div>
    </div>
</div>
