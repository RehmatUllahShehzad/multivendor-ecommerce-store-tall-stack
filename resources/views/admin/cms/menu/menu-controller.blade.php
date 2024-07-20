<x-slot name="pageTitle">
    {{ __('cms.menu.index.title') }}
</x-slot>

<div>
    <x-admin.components.table class="w-full whitespace-no-wrap p-2">
        <x-slot name="head">
            <x-admin.components.table.heading>{{ __('global.sr_no') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading>{{ __('global.name') }}</x-admin.components.table.heading>
            <x-admin.components.table.heading></x-admin.components.table.heading>
        </x-slot>
        <x-slot name="body">
            @forelse($menus as $menu)
                <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                    <x-admin.components.table.cell>{{ $loop->iteration }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>{{ $menu->name }}</x-admin.components.table.cell>
                    <x-admin.components.table.cell>
                        <a href="{{ route('admin.cms.menu.builder', $menu->id) }}" class="text-indigo-500 hover:underline">
                            {{ __('cms.menu.index.action.edit') }}
                        </a>
                    </x-admin.components.table.cell>
                </x-admin.components.table.row>
            @empty
                <x-admin.components.table.no-results />
            @endforelse
        </x-slot>
    </x-admin.components.table>
</div>
