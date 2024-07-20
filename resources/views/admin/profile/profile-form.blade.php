<div class="w-full max-w-2xl mx-auto">

    <x-admin.components.card heading="{{ __('staff.profile.title') }}">
        <div class="flex items-center">

            <div>
                <x-admin.components.gravatar email="1222{{ $staff->email }}1233" class="w-8 h-8 rounded-full" />
            </div>
            <div class="ml-4 grow">
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="p-4 rounded-md bg-blue-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-blue-500">
                                <div>
                                    <x-icon ref="exclamation-circle"></x-icon>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 ml-3 md:flex md:justify-between">
                            <p class="text-sm text-blue-700">
                                {{ __('staff.edit.avatar_message') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.firstname') }}" for="firstname" :error="$errors->first('staff.first_name')">
                <x-admin.components.input.text wire:model.defer="staff.first_name" name="first_name" id="first_name"
                    :error="$errors->first('staff.first_name')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.lastname') }}" for="lastname" :error="$errors->first('staff.last_name')">
                <x-admin.components.input.text wire:model.defer="staff.last_name" name="lastname" id="lastname"
                    :error="$errors->first('staff.last_name')" />
            </x-admin.components.input.group>
        </div>

        <x-admin.components.input.group label="{{ __('inputs.email') }}" for="email" :error="$errors->first('staff.email')">
            <x-admin.components.input.text wire:model="staff.email" type="email" name="email" id="email"
                :error="$errors->first('staff.email')" readonly />
        </x-admin.components.input.group>

        <div class="grid grid-cols-2 gap-4">
            <x-admin.components.input.group label="{{ __('inputs.current_password') }}" for="currentPassword"
                :error="$errors->first('currentPassword')">
                <x-admin.components.input.text wire:model="currentPassword" type="password" name="currentPassword"
                    id="currentPassword" :error="$errors->first('currentPassword')" />
            </x-admin.components.input.group>
            <x-admin.components.input.group label="{{ __('inputs.new_password') }}" for="password" :error="$errors->first('password')">
                <x-admin.components.input.text wire:model="password" type="password" name="password" id="password"
                    :error="$errors->first('password')" />
            </x-admin.components.input.group>
        </div>
    </x-admin.components.card>



    <div class="px-4 py-3 text-right rounded shadow bg-gray-50 sm:px-6">
        <button type="submit"
            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('staff.profile.btn') }}
        </button>
    </div>

</div>
