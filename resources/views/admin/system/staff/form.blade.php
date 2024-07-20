<div class="col-span-12 space-y-4">
    <x-admin.components.card heading="Basic Information">
        <div class="grid grid-cols-2 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.firstname') }}" for="firstname" :error="$errors->first('staff.first_name')">
                <x-admin.components.input.text wire:model.defer="staff.first_name" name="firstname" id="firstname" :error="$errors->first('staff.first_name')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.lastname') }}" for="lastname" :error="$errors->first('staff.last_name')">
                <x-admin.components.input.text wire:model.defer="staff.last_name" name="lastname" id="lastname" :error="$errors->first('staff.last_name')" />
            </x-admin.components.input.group>
        </div>
        <x-admin.components.input.group label="{{ __('inputs.email') }}" for="email" :error="$errors->first('staff.email')">
            @if ($staff->exists)
                <x-admin.components.input.text value="{{ $this->staff->email }}" readonly type="email" name="email" id="email" :error="$errors->first('staff.email')" />
            @else
                <x-admin.components.input.text wire:model="staff.email" type="email" name="email" id="email" :error="$errors->first('staff.email')" />
            @endif
        </x-admin.components.input.group>

        <div class="grid grid-cols-2 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.new_password') }}" for="password" :error="$errors->first('password')">
                <x-admin.components.input.text wire:model="password" type="password" name="password" id="password" :error="$errors->first('password')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.new_password_confirmation') }}" for="passwordConfirmation" :error="$errors->first('password_confirmation')">
                <x-admin.components.input.text wire:model="password_confirmation" type="password" name="password_confirmation" id="passwordConfirmation" :error="$errors->first('passwordConfirmation')" />
            </x-admin.components.input.group>
        </div>
    </x-admin.components.card>

    @include('admin.system.staff._permissions')


    <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __($staff->id ? 'settings.staff.form.update_btn' : 'settings.staff.form.create_btn') }}
        </button>
    </div>

    @if ($staff->id)
        <div class="bg-white border border-red-300 rounded shadow">
            <header class="px-6 py-4 text-red-700 bg-white border-b border-red-300 rounded-t">
                {{ __('inputs.danger_zone.title') }}
            </header>
            <div class="p-6 space-y-4 text-sm">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 md:col-span-6">
                        <strong>{{ __('settings.staff.form.danger_zone.label') }}</strong>
                        <p class="text-xs text-gray-600">{{ __('settings.staff.form.danger_zone.instructions') }}</p>
                    </div>
                    <div class="col-span-9 lg:col-span-4">
                        <x-admin.components.input.text type="email" wire:model="deleteConfirm" />
                    </div>
                    <div class="col-span-3 text-right lg:col-span-2">
                        <x-admin.components.button theme="danger" :disabled="!$this->canDelete" wire:click="delete" type="button">{{ __('global.delete') }}</x-admin.components.button>
                    </div>
                </div>
                @if ($this->ownAccount)
                    <x-alert level="danger">
                        {{ __('settings.staff.form.danger_zone.own_account') }}
                    </x-alert>
                @endif
            </div>
        </div>
    @endif
</div>
