<x-slot name="pageTitle">
    {{ __('staff.index.title') }}
</x-slot>

<div>
    <div class="text-right mb-4">
        <x-admin.components.button tag="a" href="{{ route('admin.system.staff.create') }}">
            {{ __('staff.index.action.create') }}
        </x-admin.components.button>
    </div>

    <div class="overflow-hidden shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">

        <div class="p-4 space-y-4">

            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-8">
                        <x-admin.components.input.text wire:model.debounce.300ms="search" placeholder="{{ __('staff.index.search_placeholder') }}" />
                    </div>
                    <div class="col-span-4 text-right md:col-span-4">
                        <x-admin.components.input.checkbox-button wire:model="showTrashed" autocomplete="off">
                            {{ __('global.show_deleted') }}
                        </x-admin.components.input.checkbox-button>
                    </div>
                </div>
            </div>
        </div>

        <x-admin.components.table class="w-full whitespace-no-wrap p-2">
            <x-slot name="head">
                <x-admin.components.table.heading>
                    <div class="w-8"></div>
                </x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.active') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.firstname') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.lastname') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading>{{ __('global.email') }}</x-admin.components.table.heading>
                <x-admin.components.table.heading></x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($staff as $staffMember)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>
                            <x-admin.components.gravatar email="1222{{ $staffMember->email }}1233" class="w-8 h-8 rounded-full" />
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <x-icon :ref="!$staffMember->deleted_at ? 'check' : 'x'" :class="!$staffMember->deleted_at ? 'text-green-500' : 'text-red-500'" style="solid" />
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $staffMember->first_name }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $staffMember->last_name }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            {{ $staffMember->email }}
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            @if (!$staffMember->deleted_at)
                                <a href="{{ route('admin.system.staff.show', $staffMember->id) }}" class="text-indigo-500 hover:underline">
                                    {{ __('staff.index.action.edit') }}
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
            {{ $staff->links() }}
        </div>
    </div>
</div>
