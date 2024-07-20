<div>
    <div
        class="overflow-hidden shadow-gray-800 dark:shadow-gray-50 border border-gray-300 dark:border-gray-500 sm:rounded-lg">
        <div class="text-right mb-4 p-4">
        </div>

        <div class="p-4 space-y-4">
            <div class="flex items-center space-x-4">
                <div class="grid grid-cols-12 w-full space-x-4">
                    <div class="col-span-8 md:col-span-10">
                        <x-admin.components.input.text wire:model.debounce.300ms="search"
                            placeholder="{{ __('Search') }}" />
                    </div>
                    <div class="col-span-4 text-right md:col-span-2">
                    </div>
                </div>
            </div>
        </div>
        <x-admin.components.table class="w-full whitespace-no-wrap p-2">
            <x-slot name="head">
                <x-admin.components.table.heading>first Name</x-admin.components.table.heading>
                <x-admin.components.table.heading>Last Name</x-admin.components.table.heading>
                <x-admin.components.table.heading>Email</x-admin.components.table.heading>
                <x-admin.components.table.heading>Type</x-admin.components.table.heading>
                <x-admin.components.table.heading>created At</x-admin.components.table.heading>
                <x-admin.components.table.heading>Action</x-admin.components.table.heading>
            </x-slot>
            <x-slot name="body">
                @forelse($forms as $form)
                    <x-admin.components.table.row wire:loading.class.delay="opacity-50">
                        <x-admin.components.table.cell>{{ $form->first_name }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $form->last_name }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $form->email }}</x-admin.components.table.cell>
                        <x-admin.components.table.cell>{{ $form->type }}</x-admin.components.table.cell>
                       
                        <x-admin.components.table.cell>{{ $form->created_at->format('m/d/Y') }}
                        </x-admin.components.table.cell>
                        <x-admin.components.table.cell>
                            <div class="flex flex-row justify-between">
                                    <a class="text-indigo-500 hover:underline"
                                        href="{{ route('admin.forms.show', $form->id) }}">
                                        {{ __('Show') }}
                                    </a>
                            </div>
                        </x-admin.components.table.cell>
                    </x-admin.components.table.row>
                @empty
                    <x-admin.components.table.no-results />
                @endforelse
            </x-slot>
            </x-table>
            <div>
                {{ $forms->links() }}
            </div>
    </div>
</div>
