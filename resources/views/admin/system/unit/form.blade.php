<div class="col-span-12 space-y-4">
    <x-admin.components.card heading="Basic Information">
        <div class="grid grid-cols-2 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.name') }}" for="name" :error="$errors->first('unit.name')">
                <x-admin.components.input.text wire:model.defer="unit.name" name="name" id="name" :error="$errors->first('unit.name')" />
            </x-admin.components.input.group>
        </div>
    </x-admin.components.card>
    
    <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __($unit->id ? 'units.form.update_btn' : 'units.form.create_btn') }}
        </button>
    </div>
    
    @if ($unit->id)
        <div class="bg-white border border-red-300 rounded shadow">
            <header class="px-6 py-4 text-red-700 bg-white border-b border-red-300 rounded-t">
                {{ __('inputs.danger_zone.title') }}
            </header>
            <div class="p-6 space-y-4 text-sm">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 md:col-span-6">
                        <strong>{{ __('units.form.danger_zone.label') }}</strong>
                        <p class="text-xs text-gray-600">{{ __('units.form.danger_zone.instructions') }}</p>
                    </div>
                    <div class="col-span-9 lg:col-span-4">
                        <x-admin.components.input.text type="text" wire:model="deleteConfirm" />
                    </div>
                    <div class="col-span-3 text-right lg:col-span-2">
                        <x-admin.components.button theme="danger" :disabled="!$this->canDelete" wire:click="delete" type="button">{{ __('global.delete') }}</x-admin.components.button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
